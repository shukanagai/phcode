const modalArea = document.getElementById('modalArea');
const openModal = document.getElementById('openModal');
const closeModal = document.getElementsByClassName('closeModal')[0];
const modalBg = document.getElementsByClassName('modalBg')[0];






openModal.addEventListener('click' , ()=>{
    modalArea.style.display = 'block';
});


closeModal.addEventListener('click' , function(){
    modalArea.style.display = 'none';
});


modalBg.addEventListener('click' , ()=>{
    modalArea.style.display = 'none';
});


/*
課題１入力フォームエラー文
提出物:1番フォルダ
提出物名:01_iw_12a_00
12/3
*/

const alertText = document.getElementsByClassName('alertText');
const inputText = document.getElementsByClassName('inputText');
const signUpButton = document.getElementsByClassName('signUpButton')[0];

const msg = ['名前を入力してください' , 'アドレスを入力してください' , 'パスワードを入力してください'];


signUpButton.addEventListener('click' , ()=>{

    for(let i=0; i<3; i++){
        if(inputText[i].value == ''){
            alertText[i].classList.add('alertBox') ;
            alertText[i].textContent = msg[i];          
        }else{
            alertText[i].className='alertText';
            alertText[i].textContent = '';
        }
    }
});



