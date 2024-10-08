
    function agregar() {

         let cantidad = document.getElementById('cantidad');
         if (cantidad.value < cantidad.max) {
         cantidad.value = parseInt(cantidad.value) + 1;
        total();
    }

}

   function quitar() {

       let cantidad = document.getElementById('cantidad');
       if (cantidad.value > cantidad.min) {
       cantidad.value = parseInt(cantidad.value) - 1;

       total();

            } 


          
    }


