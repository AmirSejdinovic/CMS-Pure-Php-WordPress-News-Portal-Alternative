

  //EDITOR CKEDITOR
  ClassicEditor
  .create( document.querySelector( '#body' ) )
  .catch( error => {
      console.error( error );
  } );
  //jquery selektujemo element sa id selectAllBoxes nakon toga dodajemo mu event listener clikc i onda pišem if recenicu
  $(document).ready(function(){
     $('#selectAllBoxes').click(function(event){
     //ako je gornji element (this) označen kao chekced dakle ako je kvadratic check boxa oznacen onda selektuj klasu tog boxa i za svaki koji ima tu klasu dodaj daj e true znači da je oznacen i svi će biti označeni
     if(this.checked){
       $('.checkBoxes').each(function(){
         this.checked = true;
       });
     }else{
       //ako nije oznacena onda neka svi checkboxovi budu false
      $('.checkBoxes').each(function(){
        this.checked = false;
      });
     }
     });
  });




