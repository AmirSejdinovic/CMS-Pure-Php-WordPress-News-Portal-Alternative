

  //EDITOR CKEDITOR
  ClassicEditor
  .create(document.querySelector( '#body' ) )
  .catch(error => {
      console.error(error);
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


     //loader 

     //pravimo varijablu sa div elemenitma koji imaju id koji su stilizovani sa css
     var div_box = "<div id='load-screen'><div id='loading'></div></div>";
     //putem jquerya pripajamo gornju varijablu dakle div sa body elementom
     $('body').prepend(div_box);
     //ciljamo div sa id load-screen onda odlazemo 700 miliskeundi kasnije vrsimo fadeOut za 600 ms i nakon toga odstranujemo
     $('#load-screen').delay(700).fadeOut(600, function(){
       $(this).remove();
     })




  });

  //Kreiramo funckiju u kojoj ćemo postaviti ajax funkcionalsnosti da dobijamo instant rezultate iz baze podataka
  function loadUsersOnline(){
          //get sa parametrima
       $.get("functions.php?onlineusers=result", function(data){
         //prikazujemo podatke iz requesta unutar elementa sa klasom .usersonline
         $(".usersonline").text(data);
       });
       
  }
  setInterval(function(){
    loadUsersOnline();
  },500);
  




