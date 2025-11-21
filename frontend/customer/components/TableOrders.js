document.addEventListener("DOMContentLoaded", async () => {
  const table = document.querySelector("#table-order");
  if (!table) {
    console.warn("orderTable element not found.");
    return;
  }
  const tableNo = localStorage.getItem("table_no");
  const response = await getApiResponse(
    "http://localhost/software_engineering/backend/orders?table_no=" +
      tableNo +
      "&is_complete=N"
  );
  const data = response.data;

  const dataTable = $(table).DataTable({
    data: data,
    columns: [
      {
        data: null,
        render: (row) => `
            <div class="text-left">
                <strong class="d-block mb-1">${row.item_name}</strong>
            </div>
        `,
      },
      {
        data: "status",
        render: (status) => {
          const statusMap = {
            P: `<span class="badge bg-secondary">Ordered</span>`,
            O: `<span class="badge bg-warning text-dark">Cooking</span>`,
            D: `<span class="badge bg-info text-dark">Delivered</span>`,
          };

          return statusMap[status] || status;
        },
      },
      { data: "quantity" },
      { data: "cost" },
    ],
    footerCallback: function (row, data) {
      let totalValue = 0;
      let totalQty = 0;
      data.forEach((item) => {
        totalValue += parseFloat(item.cost);
        totalQty += parseInt(item.quantity);
      });

      const api = this.api();
      $(api.column(2).footer()).html(totalQty);
      $(api.column(3).footer()).html("RM " + totalValue.toFixed(2));
    },
    paging: false,
    searching: false,
    ordering: false,
    info: false,
  });
});
