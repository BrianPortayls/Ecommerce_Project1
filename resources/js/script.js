const orders = [
  { id: "#FC-1048", customer: "Maya Chen", status: "Packed", className: "packed", total: "$84.20" },
  { id: "#FC-1047", customer: "Andre Mills", status: "Preparing", className: "preparing", total: "$42.75" },
  { id: "#FC-1046", customer: "Nora Patel", status: "Out for delivery", className: "delivery", total: "$128.10" },
  { id: "#FC-1045", customer: "Sam Rivera", status: "Packed", className: "packed", total: "$36.40" },
  { id: "#FC-1044", customer: "Lina Brooks", status: "Preparing", className: "preparing", total: "$59.95" },
];

const products = [
  { icon: "HS", name: "Harvest salad box", meta: "412 sold", revenue: "$7.8k" },
  { icon: "BB", name: "Berry breakfast pack", meta: "368 sold", revenue: "$6.4k" },
  { icon: "AB", name: "Artisan bread bundle", meta: "291 sold", revenue: "$4.9k" },
  { icon: "LD", name: "Local dairy crate", meta: "244 sold", revenue: "$4.1k" },
];

document.querySelector("#orders-body").innerHTML = orders
  .map(
    (order) => `
      <tr>
        <td>${order.id}</td>
        <td>${order.customer}</td>
        <td><span class="status ${order.className}">${order.status}</span></td>
        <td>${order.total}</td>
      </tr>
    `
  )
  .join("");

document.querySelector("#products-list").innerHTML = products
  .map(
    (product) => `
      <div class="product-row">
        <span class="product-thumb" aria-hidden="true">${product.icon}</span>
        <div>
          <strong>${product.name}</strong>
          <span>${product.meta}</span>
        </div>
        <strong>${product.revenue}</strong>
      </div>
    `
  )
  .join("");