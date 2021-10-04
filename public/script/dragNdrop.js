function setDragDrop(){
var draggableElements = document.getElementsByClassName("myDraggableElement");

for(let drag of draggableElements){

    drag.addEventListener("dragstart", (e) => {

        e.dataTransfer.setData("text/plain", drag.id);
        e.dataTransfer.dropEffect ="copy";
    
    });

}
}

for (const dropzone of document.querySelectorAll(".zone")){

    // Lorsque l'élément est 'drag' au dessus d'une zone de drop
    dropzone.addEventListener("dragover", (e) => {

        if(dropzone.classList.contains("dropzone")){

        e.preventDefault();

        e.dataTransfer.dropEffect ="copy";

        }
    });


    // Lorsque l'élément est drop
    dropzone.addEventListener("drop", (e)=> {

        if(dropzone.classList.contains("dropzone")){

        e.preventDefault();

        const droppedElementId = e.dataTransfer.getData("text/plain");
        const droppedElement = document.getElementById(droppedElementId);

    
        let newDragElement = droppedElement.cloneNode(true);
        dropzone.appendChild(newDragElement);
        //newDragElement.querySelector('.cross').classList.remove('d-none');
        //newDragElement.id +="Clone";
        }
        dropzone.classList.remove("drop-zone--over");

    });


    dropzone.addEventListener("dragleave", (e)=>{
    
    dropzone.classList.remove("drop-zone--over");

    });
}