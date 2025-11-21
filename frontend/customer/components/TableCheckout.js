document.addEventListener("DOMContentLoaded", () => {
  const table = document.querySelector("#table-checkout");
  if (!table) {
    console.warn("orderTable element not found.");
    return;
  }
  const tableNo = localStorage.getItem("table_no");
  const stored = localStorage.getItem("orders_" + tableNo);
  const data = stored ? JSON.parse(stored) : [];

  const dataTable = $(table).DataTable({
    data: data,
    columns: [
      {
        data: null,
        render: (row) => `
            <div class="text-left">
                <strong class="d-block mb-1">${row.name}</strong>
            </div>
        `,
      },
      {
        data: "price",
        render: (data) => parseFloat(data).toFixed(2),
      },
      { data: "quantity" },
      {
        data: null,
        render: (row) => (row.price * row.quantity).toFixed(2),
      },
      {
        data: null,
        render: (row) => `
            <div class="text-center" style="display:flex; gap:2px;">
                <button class="btn btn-success btn-sm btn-change-status"
                        data-row='${JSON.stringify(row)}'
                        data-bs-toggle="modal"
                        data-bs-target="#changeStatusModal">
                    <i class="fas fa-edit"></i>
                </button>

                <button class="btn btn-danger btn-sm btn-remove-order"
                        data-row='${JSON.stringify(row)}'
                        data-bs-toggle="modal"
                        data-bs-target="#removeOrderModal">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        `,
      },
    ],
    footerCallback: function (row, data) {
      let total = 0;
      data.forEach((item) => {
        total += item.price * item.quantity;
      });

      const api = this.api();
      $(api.column(3).footer()).html("RM" + total.toFixed(2));
    },
    paging: false,
    searching: false,
    ordering: false,
    info: false,
  });

  // #region Edit Button
  $(table).on("click", ".btn-change-status", function () {
    const rowData = JSON.parse(this.dataset.row);
    document.querySelector("#modalImage").src = rowData.image_url; // NEW
    document.querySelector("#modalItemName").textContent = rowData.name;
    document.querySelector("#modalQuantity").value = rowData.quantity;
    document.querySelector("#modalPrice").textContent = rowData.price; // NEW
    document.querySelector("#saveChangesBtn").dataset.id = rowData.item_id;
  });

  document.querySelector("#saveChangesBtn")?.addEventListener("click", () => {
    const itemId = document.querySelector("#saveChangesBtn").dataset.id;
    const newQty = parseInt(document.querySelector("#modalQuantity").value);

    const rowIndex = data.findIndex((item) => item.item_id == itemId);
    if (rowIndex !== -1) {
      data[rowIndex].quantity = newQty;
      localStorage.setItem("orders_" + tableNo, JSON.stringify(data));
      dataTable.clear().rows.add(data).draw();
    }
  });
  // #endregion

  // #region Delete Button
  $(table).on("click", ".btn-remove-order", function () {
    const rowData = JSON.parse(this.dataset.row);
    document.querySelector("#removeItemName").textContent = rowData.name;
    document.querySelector("#confirmRemoveBtn").rowData = rowData;
  });

  document.querySelector("#confirmRemoveBtn")?.addEventListener("click", () => {
    const rowData = document.querySelector("#confirmRemoveBtn").rowData;

    const newData = data.filter((item) => item.index !== rowData.index);
    newData.forEach((item, i) => (item.index = i));
    localStorage.setItem("orders_" + tableNo, JSON.stringify(newData));

    const cartCount = document.getElementById("cart_count");
    cartCount.textContent = newData.length;
    localStorage.setItem("cart_count", newData.length);

    dataTable.clear().rows.add(newData).draw();
    data.length = 0;
    data.push(...newData);
  });
  // #endregion
});
