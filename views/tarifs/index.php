<section class="d-none d-md-none d-xl-block">
      <div class="container">
         <div class="bloc location">
            <h2>Location de materiel</h2>
            <div class="bloc-info row">
               <div class="col-lg-6">
                  <img src="images/planchesdesurf.jpg" alt="Planches de surf" class="img-fluid">
               </div>
               <div class="col-lg-6">
                  <p>Nous proposons du matériel de location de qualité, avec un grand choix de planches de surf et de bodyboard ainsi que des combinaisons.<br /><br /> Tarifs : à partir de 7 €</p>
               </div>
            </div>
            <h2>Tarifs</h2>
            <table class="table">
               <thead>
                  <tr>
                     <th>Tarifs location</th>
                     <th>Planche de surf</th>
                     <th>Bodyboard</th>
                     <th>Combinaison</th>
                  </tr>
               </thead>
               <tbody>
                  <?php foreach ($tarifs as $location){
echo ('
<tr>
<td>
');
var_dump($location);
                  }?>