if (window.swal && typeof window.swal.fire == 'undefined') {
const original = window.swal;
window.swal.fire = function () {
arguments = [...arguments][0];

if(typeof arguments != 'undefined'){
arguments.buttons = {}

if(typeof arguments.confirmButtonText != 'undefined'){
arguments.buttons.confirm = {
text: arguments.confirmButtonText,
value: true,
visible: true,
className: "",
closeModal: true
}
}

if(typeof arguments.cancelButtonText != 'undefined'){
arguments.buttons.cancel = {
text: arguments.cancelButtonText,
value: false,
visible: true,
className: "",
closeModal: true
}
}

}

return window.swal.call(original, arguments);
};
}