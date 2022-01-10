<section class="ouverture">
   <div class="container">
      <div class="bloc gestion">
         <h2>Bonjour, admin</h2>
         <h3>Quel voulez-vous faire? </h3>
         <div class="row justify-content-md-center">
            <div class="col-lg-11">
               <div class="row">
                  <div class="col-sm-4">
                     <div class="card">
                        <div class="card-body">
                           <h4 class="card-title">Mettre à jour</h4>
                           <p class="card-text">Mettre à jour un ou plusieurs tarifs de location de matériel</p>
                           <form action="/gestion/modifier">
                              <button type="submit" class="btn btn-lg">Modifier</button>
                           </form>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-4">
                     <div class="card">
                        <div class="card-body">
                           <h4 class="card-title">Nouveau tarif</h4>
                           <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error officia perspiciatis voluptas porro in. Soluta.</p>

                           <form action="/gestion/nouveau">
                              <button type="submit" class="btn btn-lg">Nouveau</button>
                           </form>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-4">
                     <div class="card">
                        <div class="card-body">
                           <h4 class="card-title">Supprimer</h4>
                           <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus qui ea, neque quasi suscipit consectetur.</p>
                           <form action="/gestion/supprimer">
                              <button type="submit" class="btn btn-lg">Supprimer</button>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-lg-12">
               <img src="public/assets/images/coursdesurf.jpg" alt="Cours de surf" class="img-thumbnail">
            </div>
         </div>
      </div>
   </div>
</section>