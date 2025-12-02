window.addEventListener("DOMContentLoaded", (event) => {
  // Global Variables
  let simpleDataTableInstance = null;
  const datatablesOrders = document.getElementById("datatablesOrders");
  const API_URL = "http://localhost/software_engineering/backend/orders";

  // =========================================
  // 1. HELPER FUNCTIONS (Status & Formatting)
  // =========================================

  function getStatusText(status) {
    let colorClass = "bg-secondary";
    let customClass = "order-status-unknown";
    let text = "Unknown";
    let sortKey = "3";

    switch (status) {
      case "D":
        colorClass = "bg-success";
        customClass = "order-status-delivered";
        text = "Delivered";
        sortKey = "2";
        break;
      case "O":
        colorClass = "bg-warning text-dark";
        customClass = "order-status-cooking";
        text = "Cooking";
        sortKey = "1";
        break;
      case "P":
        colorClass = "bg-danger";
        customClass = "order-status-pending";
        text = "Pending";
        sortKey = "0";
        break;
    }
    // Note: The hidden span allows the table to sort by status ID (0, 1, 2) instead of alphabetically
    return `<span style="display: none;">${sortKey}</span><span class="badge ${colorClass} order-status-badge ${customClass}">${text}</span>`;
  }

  function getCompletionStatusText(isComplete) {
    let colorClass, text, customClass, sortKey;

    if (isComplete === "Y") {
      colorClass = "bg-success";
      text = "Yes";
      customClass = "order-complete-y";
      sortKey = "1";
    } else if (isComplete === "N") {
      colorClass = "bg-danger";
      text = "No";
      customClass = "order-complete-n";
      sortKey = "0";
    } else {
      colorClass = "bg-secondary";
      text = "N/A";
      customClass = "order-complete-na";
      sortKey = "2";
    }
    return `<span style="display: none;">${sortKey}</span><span class="badge ${colorClass} order-status-badge ${customClass}">${text}</span>`;
  }

  function getStatusWeight(status) {
    switch (status) { case "P": return 0; case "O": return 1; case "D": return 2; default: return 3; }
  }

  function getCompletionWeight(isComplete) {
    switch (isComplete) { case "N": return 0; case "Y": return 1; default: return 2; }
  }

  // =========================================
  // 2. ACTION BUTTONS (The Fix)
  // =========================================

  function getActionButtons(order) {
    // 🛠️ CRITICAL FIX: Use encodeURIComponent.
    // This turns { name: "Chef's Special" } into safe text like %7B%22name%22%3A%22Chef's%20Special%22%7D
    // This prevents quotes from breaking the HTML button attribute.
    const safeData = encodeURIComponent(JSON.stringify(order));

    return `
            <button class="btn btn-success btn-sm btn-change-status" data-order="${safeData}" title="Change Status/Quantity"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger btn-sm btn-remove-order" data-order="${safeData}" title="Remove"><i class="fa-solid fa-trash"></i></button>
        `;
  }

  // =========================================
  // 3. MODAL LOGIC & LISTENERS
  // =========================================

  function prefillChangeModal(order) {
    document.getElementById("changeOrderId").value = order.id || "";
    document.getElementById("currentOrderItem").value = order.item_name || "N/A";
    document.getElementById("newQuantity").value = order.quantity || 1;

    let currentStatusText = "";
    switch (order.status) {
      case "D": currentStatusText = "Delivered"; break;
      case "O": currentStatusText = "Cooking"; break;
      case "P": currentStatusText = "Pending"; break;
      default: currentStatusText = "Unknown"; break;
    }
    document.getElementById("currentStatus").value = currentStatusText;
    document.getElementById("newStatus").value = "";

    const modalElement = document.getElementById("changeStatusModal");
    modalElement.setAttribute("data-original-quantity", order.quantity || "1");
    modalElement.setAttribute("data-original-status", order.status || "");
  }

  function prefillRemoveModal(order) {
    document.getElementById("removeOrderId").value = order.id || "";
    document.getElementById("removeOrderItem").textContent = order.item_name || "this item";
  }

  function setupModalListeners() {
    // A. LISTENER FOR TABLE CLICKS (Delegation)
    document.body.addEventListener("click", function (e) {
      // Find the closest button if the icon was clicked
      const btn = e.target.closest(".btn-change-status, .btn-remove-order");
      if (!btn) return;

      try {
        // 🛠️ CRITICAL FIX: Decode the safe string back to JSON
        const rawAttribute = btn.getAttribute("data-order");
        if (!rawAttribute) return;

        const orderData = JSON.parse(decodeURIComponent(rawAttribute));

        if (btn.classList.contains("btn-change-status")) {
          // 1. Fill data
          prefillChangeModal(orderData);
          // 2. Show Modal Manually
          new bootstrap.Modal(document.getElementById('changeStatusModal')).show();

        } else if (btn.classList.contains("btn-remove-order")) {
          // 1. Fill data
          prefillRemoveModal(orderData);
          // 2. Show Modal Manually
          new bootstrap.Modal(document.getElementById('removeOrderModal')).show();
        }
      } catch (error) {
        console.error("Error parsing order data:", error);
        alert("System Error: Could not load order details.");
      }
    });

    // B. LISTENER FOR "SAVE CHANGES" BUTTON
    const saveBtn = document.getElementById("saveStatusChange");
    if (saveBtn) {
      saveBtn.addEventListener("click", async function () {
        const orderId = document.getElementById("changeOrderId").value;
        const newStatus = document.getElementById("newStatus").value;
        const newQuantity = document.getElementById("newQuantity").value;
        const modalElement = document.getElementById("changeStatusModal");
        const originalQuantity = modalElement.getAttribute("data-original-quantity");
        const originalStatus = modalElement.getAttribute("data-original-status");

        // Validation
        if (!newQuantity || parseInt(newQuantity) < 1) {
          alert("Quantity must be 1 or more.");
          return;
        }

        // Build Payload
        const payload = { id: orderId };
        let changed = false;

        if (newStatus && newStatus !== originalStatus) {
          payload.status = newStatus;
          changed = true;
        }
        if (newQuantity != originalQuantity) {
          payload.quantity = newQuantity;
          changed = true;
        }

        const modalInstance = bootstrap.Modal.getInstance(modalElement);

        if (!changed) {
          alert("No changes were made.");
          if (modalInstance) modalInstance.hide();
          return;
        }

        // API Call
        const response = await getApiResponse(API_URL, "PATCH", payload);

        if (response.success) {
          alert(`Order updated successfully!`);
          if (modalInstance) modalInstance.hide();
          await initializeDataTable(); // Refresh table
        } else {
          alert(`Failed to update: ${response.message || "Unknown Error"}`);
        }
      });
    }

    // C. LISTENER FOR "CONFIRM REMOVE" BUTTON
    const removeBtn = document.getElementById("confirmRemoveOrder");
    if (removeBtn) {
      removeBtn.addEventListener("click", async function () {
        const orderId = document.getElementById("removeOrderId").value;

        // API Call
        const response = await getApiResponse(API_URL, "DELETE", { id: orderId });

        if (response.success || response.message) {
          alert(response.message || "Order removed.");
          const modalInstance = bootstrap.Modal.getInstance(document.getElementById("removeOrderModal"));
          if (modalInstance) modalInstance.hide();
          await initializeDataTable(); // Refresh table
        } else {
          alert(`Failed to remove: ${response.error || response.message || "Unknown Error"}`);
        }
      });
    }
  }

  // =========================================
  // 4. MAIN TABLE INITIALIZATION
  // =========================================

  async function initializeDataTable() {
    if (!datatablesOrders) return;

    const headings = ["Item", "Category", "Quantity", "Table Number", "Time", "Cost", "Status", "Completed", "Actions"];

    // Fetch Data
    const response = await getApiResponse(API_URL);

    if (!response || !response.success || !Array.isArray(response.data)) {
      datatablesOrders.innerHTML = '<tr><td colspan="9" class="text-center">Error loading data or Authentication failed.</td></tr>';
      return;
    }

    // Sort and Map Data
    const dataForTable = response.data
      .filter((order) => order != null)
      .sort((a, b) => {
        // Sort Priority: Completed? -> Status -> Date/Time
        const completionA = getCompletionWeight(a.is_complete);
        const completionB = getCompletionWeight(b.is_complete);
        if (completionA !== completionB) return completionA - completionB;

        const statusWeightA = getStatusWeight(a.status);
        const statusWeightB = getStatusWeight(b.status);
        if (statusWeightA !== statusWeightB) return statusWeightA - statusWeightB;

        const timeA = a.order_time ?? "";
        const timeB = b.order_time ?? "";
        const [dateA, actualTimeA] = timeA.split(" ");
        const [dateB, actualTimeB] = timeB.split(" ");
        const dateComparison = dateB.localeCompare(dateA);
        if (dateComparison !== 0) return dateComparison;
        return actualTimeA.localeCompare(actualTimeB);
      })
      .map((order) => {
        const cost = parseFloat(order.cost ?? "0.00");
        const quantity = parseInt(order.quantity ?? 0, 10);

        return [
          String(order.item_name ?? "N/A"),
          String(order.category_name ?? "N/A"),
          String(quantity),
          String("Table " + order.table_no ?? "error"),
          String(order.order_time ?? "N/A"),
          String("RM " + cost.toFixed(2) ?? "error"),
          getStatusText(order.status ?? "error"),
          getCompletionStatusText(order.is_complete ?? "N/A"),
          getActionButtons(order), // Generates the buttons with safe data
        ];
      });

    // Destroy old instance if exists
    if (simpleDataTableInstance) {
      try {
        simpleDataTableInstance.destroy();
      } catch (e) { console.log("Table reset"); }
    }

    // Create new Table
    simpleDataTableInstance = new simpleDatatables.DataTable(datatablesOrders, {
      data: { headings: headings, data: dataForTable },
      perPageSelect: [10, 25, 50, 100],
      columns: [{ select: 8, sortable: false }], // Disable sorting on 'Actions' column
      labels: { perPage: "", info: "Displaying {start} of {end} of {rows} Orders" },
    });
  }

  // =========================================
  // 5. STARTUP
  // =========================================

  // 1. Setup the modal button listeners once
  setupModalListeners();

  // 2. Load the table
  initializeDataTable();
});