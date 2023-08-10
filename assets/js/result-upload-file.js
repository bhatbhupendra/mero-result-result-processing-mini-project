const clickableArea = document.getElementById('clickable-area');
const formInput = document.getElementById('result-upload-form-input');
const forSubmit = document.getElementById('result-upload-submit');

clickableArea.addEventListener("click",()=>{
    formInput.click();
});
formInput.onchange = function (){
    forSubmit.click();
};