const clickableArea = document.getElementById('clickable-area');
const formInput = document.getElementById('student-upload-form-input');
const forSubmit = document.getElementById('student-upload-submit');

clickableArea.addEventListener("click",()=>{
    formInput.click();
});
formInput.onchange = function (){
    forSubmit.click();
};