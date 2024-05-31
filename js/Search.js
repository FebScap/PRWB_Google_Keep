let labels = Array(), labelsChecked = Array(), userCards = Array(), sharedDiv = Array(), sharedTitles = Array();
let userDiv, userTitle;

$(document).ready(function() {
    userCards = document.getElementsByClassName('userCard');
    sharedDiv = document.getElementsByClassName('sharedDiv');
    userDiv = document.getElementById('userNotes');
    sharedTitles = document.getElementsByClassName('sharedTitle');
    userTitle = document.getElementById('userTitle');
    loadElements();
});

function boxChecked(input) {    
    loadElements();
}

function refreshData() {
    let checkBoxes = document.getElementsByClassName('searchCheckbox');
    labels = Array(), labelsChecked = Array();

    for (let index = 0; index < checkBoxes.length; index++) {
        const element = checkBoxes[index];
        labelsChecked.push(element.checked);
        labels.push(element.value);
    }
}

function getAllCheckedLabel() {
    checkedLabels = Array();
    for (let index = 0; index < labelsChecked.length; index++) {
        const element = labelsChecked[index];
        if (element) {
            checkedLabels.push(labels[index]);
        }
    }
    return checkedLabels;
}

function nothingChecked() {
    refreshData();
    somethingChecked = false;
    for (let index = 0; index < labelsChecked.length; index++) {
        const element = labelsChecked[index];
        if (element) {
            somethingChecked = true;
        }
    }
    return !somethingChecked;
}

function loadElements() {
    refreshData();
    // Affichage de tout les elements
    if (nothingChecked()) {
        //Parcours de toutes les user cards
        for (let i = 0; i < userCards.length; i++) {
            const card = userCards[i];
            card.classList.remove("collapse");
        }

        //Parcours de tout les titles
        for (let i = 0; i < sharedTitles.length; i++) {
            const title = sharedTitles[i];
            title.classList.remove("collapse");
        }

        //Parcours de tout les div shared By
        for (let i = 0; i < sharedDiv.length; i++) {
            const div = sharedDiv[i];
            //Parcours de toutes les notes shared by
            for (let j = 0; j < div.children.length; j++) {
                const card = div.children[j];
                card.classList.remove("collapse");
            }
        }

    // Recherche spéciale    
    } else {
        const includesAll = (arr, values) => values.every(v => arr.includes(v));
        //Parcours de toutes les user cards
        let count = 0;
        for (let i = 0; i < userCards.length; i++) {
            const card = userCards[i];
            const cardLabels = card.children[0].children[0].children[1].children[1].children;
            let noteLabels = Array();
            let checkedLabels = getAllCheckedLabel();
            for (let j = 0; j < cardLabels.length; j++) {
                const label = cardLabels[j].innerHTML;
                noteLabels.push(label);
            }
            if (includesAll(noteLabels, checkedLabels)) {
                card.classList.remove("collapse");
                count++;
            } else {
                card.classList.add("collapse");
            }
        }
        if (count > 0) {
            userTitle.classList.remove("collapse")
        } else {
            userTitle.classList.add("collapse")
        }

        //Parcours de tout les div shared By
        for (let i = 0; i < sharedDiv.length; i++) {
            const div = sharedDiv[i];
            count = 0;
            //Parcours de toutes les notes shared by
            for (let j = 0; j < div.children.length; j++) {
                const card = div.children[j];
                const cardLabels = card.children[0].children[0].children[1].children[1].children;
                let noteLabels = Array();
                let checkedLabels = getAllCheckedLabel();
                for (let j = 0; j < cardLabels.length; j++) {
                    const label = cardLabels[j].innerHTML;
                    noteLabels.push(label);
                }
                if (includesAll(noteLabels, checkedLabels)) {
                    card.classList.remove("collapse");
                    count++;
                } else {
                    card.classList.add("collapse");
                }
            }

            //Parcours de tout les titles
            for (let i = 0; i < sharedTitles.length; i++) {
                const title = sharedTitles[i];
                if (count > 0 && title.getAttribute('owner') == div.id) {
                    title.classList.remove("collapse");
                } else {
                    title.classList.add("collapse");
                }
            }
        }
    }
}