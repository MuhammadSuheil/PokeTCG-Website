const buttonOpen = document.getElementById("form-tambah");
const buttonClose = document.getElementById("form-close");
const form = document.getElementById("tambah-produk");

buttonOpen.addEventListener("click", () => {
    form.classList.add("open");
})

buttonClose.addEventListener("click", () => {
    form.classList.remove("open");
})
