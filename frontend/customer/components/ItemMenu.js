function ItemMenu(itemData) {
  const imageUrl = "../../backend/public/storage" + itemData.image_url;
  const col = document.createElement("div");
  col.className = "col mb-5";

  const card = document.createElement("div");
  card.className = "card h-100 shadow-sm";
  card.style.maxWidth = "175px";

  const imgWrapper = document.createElement("div");
  imgWrapper.style.height = "100px";
  imgWrapper.style.overflow = "hidden";

  const img = document.createElement("img");
  img.className = "card-img-top";
  img.src = imageUrl;
  img.alt = itemData.name;
  img.style.width = "100%";
  img.style.objectFit = "cover";
  img.style.height = "100%";

  const body = document.createElement("div");
  body.className = "card-body p-4 text-center";
  body.innerHTML = `
    <h5 class="fw-bolder">${itemData.name}</h5>
    RM ${itemData.price}
  `;

  const footer = document.createElement("div");
  footer.className =
    "card-footer p-4 pt-0 border-top-0 bg-transparent text-center";

  const btn = document.createElement("button");
  btn.className = "btn btn-outline-dark mt-auto";
  btn.dataset.bsToggle = "modal";
  btn.dataset.bsTarget = "#productModal";
  btn.dataset.id = itemData.id;
  btn.dataset.name = itemData.name;
  btn.dataset.price = itemData.price;
  btn.dataset.image = imageUrl;
  btn.dataset.image_url = itemData.image_url;
  btn.dataset.description = itemData.description;
  btn.textContent = "View Details";

  footer.appendChild(btn);
  imgWrapper.appendChild(img);
  card.append(imgWrapper, body, footer);
  col.appendChild(card);

  return col;
}
