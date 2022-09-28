// ------------------------------ animation home-page-----------------------------------

var basicTimeline = anime.timeline();

    basicTimeline
    .add({
        targets: "#basicTimeline .first.el",
        translateX: 1200,
        easing: "easeOutExpo",
        delay: 1500,
    })
    .add({
        targets: "#basicTimeline .second.el",
        translateX: 1200,
        easing: "easeOutExpo",
    })
    .add({
        targets: "#basicTimeline .third.el",
        translateX: 1650,
        easing: "easeOutExpo",
    })
    .add({
        targets: "#basicTimeline .fourth.el",
        translateX: 1750,
        easing: "easeOutExpo",
    })
    .add({
        targets: "#basicTimeline .fiveth.el",
        translateX: 1650,
        easing: "easeOutExpo",
    });

   //------------------------------fonction pour afficher mon texte lettre par lettre user-rdv---------


const myText = document.getElementById("myText");
const txt = myText.dataset.label;
let i = 0;
function showLetters() {
    let timeOut;
    if (i < txt.length) {
        myText.innerHTML += `<span>${txt[i]}</span>`;
        timeOut = setTimeout(showLetters,80)
        i++
    }
    else {
        clearTimeout(timeOut);
    }
}
showLetters();

//--------------------------- bouton done page admin----------------
const devisAdminBtn= document.getElementsByClassName('devis-admin-btn');
console.log(devisAdminBtn);

function clickDone(num){  

    const divAdmin = document.getElementById('div'+num);
    // divAdmin.classList.add('done');

    if(divAdmin.classList.contains('done')){
        delete divAdmin;
    }else{
        divAdmin.classList.add('done');
    }
};



