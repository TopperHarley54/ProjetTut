<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<script>
	function verif_INF(champ_prix, champ_promo) {
		champ_prix = document.getElementsByName("champ_prix");
		champ_promo = document.getElementByName("champ_promo");
		
		var valeur_prix = champ_prix.value;
		var valeur_promo = champ_promo.value;
		
		if(valeur_prix <= valeur_promo){
			alert("Le prix de promotion de l'article doit être inférieur au prix initial");
		}
		
	}
</script>
<?php

	include_once 'Article.php';
	include_once 'liste.php';
	include_once 'Client.php';
	include_once 'Magasin.php';
	
	class Affichage{

		public static function BarreNav(){         
			echo '<script>var $(".ul li").on("click", function(){
   $(".nav").find(".active").removeClass("active");
   $(this).parent().addClass("active");
});</script>
            
            <nav class="navbar navbar-inverse" role="navigation" >
					<div class="row">
          <div class="col-lg-offset-1 col-lg-10">
                    <div class = "col-lg-9">
                    
						<img id="logo" src="inQontrol_qdance.png" style="max-height:75px; max-width:75px; float:left;"/>
                        <h1 class="col-lg-3" style="color:red;">Promo Sphère</h1>
                        <div class="col-lg-offset-1 col-lg-7" style="margin-top:1%">
                        <ul class="nav navbar-nav">
				            <li class="active" >
								<a href="PromoSphere.php">Accueil</a>
							</li>
                        
							<li >
								<a href="PromoSphere.php?a=SignalerProm">Signaler une promotion</a>
							</li>
				
							<li >
								<a href="PromoSphere.php?a=toutePromo">Les promotions</a>
							</li>
							<li >
								<a href="PromoSphere.php?a=AfficherPanier">Liste de shopping</a>
							</li>';
						if(isset($_SESSION['profil']['com'])){
			echo'			<li >
								<a href="PromoSphere.php?a=Ajoutmag">Ajouter magasin</a>
							</li>';
						}
			echo'			</ul> 
            </div>
                        
                        
					</div>';
					
			if(isset($_SESSION['profil'])){
				echo	'	<div class="col-lg-2">
							Bonjour ' . $_SESSION['profil']['prenom'] .

							'<a href="PromoSphere.php?a=Deconnexion"><p class="log">Deconnexion</p></div></a>

						</div>
                        </div>
					</nav>';	
			}else{
				echo	'	<div class="col-lg-2">
              <br>
							<a class="col-lg-6" href="PromoSphere.php?a=Connexion"><p class="log">Se connecter</p></a>
							<a class="col-lg-6" href="PromoSphere.php?a=Inscription"><p class="log">S\'inscrire</p></a>
						</div>
            </div>
					</nav>';
			}
		}
		
		
		public static function Accueil(){

      echo ' <div class="col-lg-offset-1 col-lg-10">
      <div id="lastProd">Les derniers produits signalés...</div><br> 
            
      
      ';
			Affichage::AfiAll();
      
      echo '</div>';

		}
		
		public static function Connexion(){
			
			echo '<div>';
				echo '<form action="Connexion.php" method="post">

					<label for="Login">Login</label>
					<input type="text" name="login" value=""/>

					<label for="mdp">Mot de passe</label>
					<input type="password" name="mdp" value=""/>

					<input type="submit" value="Se connecter"/>
					</form>';			
			echo '</div>';
		}
		
		public static function Deconnexion(){
			unset($_SESSION['profil']);
			session_unset();
			session_destroy();
			header ('Location: PromoSphere.php?a=accueil');
		}
		
		public static function Inscription(){
			echo '<div>';
			echo '<form action="Inscription.php" method="post">
			
				<label for="Login">Login</label>
				<input type="text" name="login" value=""/>
				
				<label for="mdp">Mot de passe</label>
				<input type="password" name="mdp" value=""/>
				
				<label for="prenom">Prenom</label>
				<input type="text" name="prenom" value=""/>
					
				<label for="nom">Nom</label>
				<input type="text" name="nom" value=""/>

				<label for="email">Email</label>
				<input type="text" name="email" value=""/>

				<input type="submit" value="S\'inscrire"/>
				</form>';
			echo '</div>';
		}
		
		public static function Afi($art){
            echo'<br><hr /><br>';
								

			echo '<div class="col-lg-offset-1 col-lg-10" style="border-style:solid; border-radius: 5px; box-shadow: 5px 5px 15px black;">'; 	 
					echo	'<div class="row" style="background:#F0EAE7;"><div class="bigbox">
								<h2 class="col-lg-offset-2 col-lg-2">';
								echo $art->nom_article;
               echo '</h2>
								<div class="row"> <!-- box affichant les informations du produit -->
                 <div class="col-lg-offset-4 col-lg-8">             
                  <div class="col-lg-3" >
                  <br><br>
                                    <img class="img-circle" src="'. $art->photo .'" />
						      </div>  <!-- fin de div contenant img --> 
									<div class="col-lg-offset-3 col-lg-5" style="border-style:solid; border-radius: 5px; box-shadow: 5px 5px 15px black; background:#B8ABA5;"><div class="descr-box" style="font-size:inherit; text-shadow:inherit; font-weight:bolder;">
                  <br>
										<div class="row"><div class="col-lg-12">Prix: <del>'. $art->prix .'</del></div></div>';
										
									echo' <div class="row"><div class="col-lg-12">Prix promo :'. $art->prix_promo .'</div></div><br>';
									
									if(isset($_SESSION['profil'])){
										$count = liste::countArtById($_SESSION['profil']['userid']);
										if($count['nombre']  == 0){
											echo'	<a href="PromoSphere.php?a=addLs&idart='. $art->id_article .'"><button class="btn btn-primary">Ajouter à la liste</button></a>';
										}else{
											echo'	<a href="PromoSphere.php?a=supLs&idart='. $art->id_article .'"><button class="btn btn-primary">Retirer de la liste</button></a>';
										}
									}else{
										echo'	<a href="PromoSphere.php?a=addLs&idart='. $art->id_article .'"><button class="btn btn-primary">Ajouter a la liste</button></a>';
									}			
									
									$mag = new Magasin();
									$mag = Magasin::findById($art->id_magasin);
									
									if($art->id_client != null){
										$cli = new Client();
										$cli = Client::findById($art->id_client);
										echo '<br> Mise en ligne par <b>'. $cli->login_client .'</b>.';
									}else{
										if($art->id_magasin != null){
											echo '<br> Mise en ligne par <b>☆'. $mag->nom_magasin .'</b>.';
										}
									}
                                  
									echo'	<a href=PromoSphere.php?a=modifProm&idart='. $art->id_article .'><div class="row"><br><div class="col-lg-12"><button class="btn btn-primary">Modifier la promotion</button></div></div></a>
                                      <br>Période promotion: '. $art->datedebut .' au '. $art->datefin.'
										<div class="row"><br><div class="col-lg-12"> Ce produit est disponible à '. $mag->nom_magasin .'</div></div>
										<div class="row"><div class="col-lg-12">Au '. $mag->numero .', '. $mag->rue .', '. $mag->ville .'</div></div>
										<div class="row">
                      <br>';
									
									
									echo	'<div class="col-lg-12">Ce bon plan n\'existe plus ? <a href="PromoSphere.php?a=supProm&idart='. $art->id_article .'"><button class="btn btn-primary">Supprimer</button> </a><div><br></div></div>
										</div>
									</div></div>
                                   

								</div>
                </div>
                <hr />
								
								<div class="col-lg-offset-2 col-lg-8"><div class="descr-box">
                                Description : '.																						
									$art->description.' <br>';
                  echo 'Taille(s): '. $art->taille_dispo .'     <br>';
									echo '     Couleur: '. $art->couleur .'<br><br>';
                  
								echo'</div></div>
                <br><br>
 
							</div>
							</div>
					</div>';
                    
		}
		
		public static function AfiAll(){				  
				foreach (Article::findAll() as $art) {
					Affichage::Afi($art);
				}
		}
		
		public static function AfiLs(){
			if(isset($_SESSION['profil'])){
				$temp = 0;
				foreach(Liste::findArtByIdCli($_SESSION['profil']['userid']) as $lis){
					$a = new Article();
					$a = Article::findById($lis->id_article);
					Affichage::Afi($a);
                    echo'<div><hr /><br></div>';
				}
				if($temp == 0){
					echo 'Votre liste est vide';
				}
				
			}
		
		}
		
		public static function AjoutListe($idart){
				liste::ajoute($idart,$_SESSION['profil']['userid']);
		}
		
		
		public static function NouvelPromo(){
			echo '<div class="col-lg-12">';
			echo '<form action="NvPromo.php" method="post">
			  
        <div class="row">
        <div class="col-lg-offset-4 col-lg-2"><div id="lastProd">Ajouter un bon plan :</div></div><br><br><br>
        <div class="col-lg-offset-4 col-lg-1">
				<label for="cbarre">code barre</label>
        </div>
        <div class="col-lg-2">
        <input type="text" name="cbarre" value=""/>
        </div>
        </div>
				<br><br>
				
        <div class="row">
        <div class="col-lg-offset-4 col-lg-1">
				<label for="narticle">Nom de l\'article</label>
        </div>
        <div class="col-lg-2">
        <input type="text" name="narticle" value=""/>
        </div>
        </div>
				<br><br>
				
        <div class="row">
        <div class="col-lg-offset-4 col-lg-1">
				<label for="prix">Prix origine</label>				
        </div>
        <div class="col-lg-2">
        <input type="text" name="prix" value=""/>
        </div>
        </div>
				<br><br>
				
        <div class="row">
        <div class="col-lg-offset-4 col-lg-1">
				<label for="prixprom">Prix promotion</label>
        </div>
        <div class="col-lg-1">	
        <input type="text" name="prixprom" value=""/>
        </div>
        </div>
				<br><br>
				
        <div class="row">
        <div class="col-lg-offset-4 col-lg-1">
				<label for="desc">Description</label>
        </div>
        <div class="col-lg-1">
        <textarea name="desc" rows="5" cols="50" > Description </textarea> 
        </div>
        </div>
				<br>
				
        <div class="row">
        <div class="col-lg-offset-4 col-lg-1">
				<label for="image">Image produit</label>			
        </div>
        <div class="col-lg-1">
        <input type="file" name="photo" />
        </div>
        </div>
				<br><br>
				
        <div class="row">
        <div class="col-lg-offset-4 col-lg-1">
				<label for="taille">Taille disponible</label>			
        </div>
        <div class="col-lg-1">
        <input type="text" name="taille" value=""/>
        </div>
        </div>
				<br><br>
				
        <div class="row">
        <div class="col-lg-offset-4 col-lg-1">
				<label for="datedeb">Date début</label>				
        </div>
        <div class="col-lg-1">
        <input type="date" name="datedeb">
        </div>
        </div>
				<br><br>
				
        <div class="row">
        <div class="col-lg-offset-4 col-lg-1">
				<label for="datefin">Date fin</label>
        </div>
        <div class="col-lg-1">
        <input type="date" name="datefin">
        </div>
        </div>
				<br>

        <div class="row">
        <div class="col-lg-offset-4 col-lg-1">				
        </div>
        <div class="col-lg-1">
        <input type="submit" onclick="verif_INF(prix,prixprom)" value="Valider promo" class="btn btn-primary"/>
        </div>
        </div>
				</form>';
			echo '</div>';
		}
		
		public static function ModifPromo($art){
			echo '<div>';
			echo '<form action="ModifPromo.php?idart='.$art->id_article.'" method="post">
			
				<label for="cbarre">code barre</label>
				<input type="text" name="cbarre" value="'.$art->code_barre.'"/>
				<br><br>
				
				<label for="narticle">Nom de l\'article</label>
				<input type="text" name="narticle" value="'.$art->nom_article.'"/>
				<br><br>
				
				<label for="prix">Prix origine</label>
				<input type="text" name="prix" value="'.$art->prix.'"/>
				<br><br>
					
				<label for="prixprom">Prix promotion</label>
				<input type="text" name="prixprom" value="'.$art->prix_promo.'"/>
				<br><br>
				
				<label for="desc">Description</label>
				<textarea name="desc" rows="5" cols="50" >'.$art->description.' </textarea> 
				<br>
				
				<label for="image">Image produit</label>
				<input type="file" name="photo">'.$art->photo.' </> 
				<br><br>
				
				<label for="taille">Taille disponible</label>
				<input type="text" name="taille" value="'.$art->taille_dispo.'"/>
				<br><br>
				
				<label for="datedeb">Date début</label>
				<input type="date" name="datedeb"> '.$art->datedebut.' </>
				<br><br>
				
				<label for="datefin">Date fin</label>
				<input type="date" name="datefin"> '.$art->datefin.' </>
				<br>

				<input type="submit" value="Valider promo"/>
				</form>';
			echo '</div>';
		}
		
		public static function Ajoutmag(){
			echo '<div class="col-lg-12">';
			echo'	<form method="post" action="Nvmag.php">
						
						<div class="row">
							<div class="col-lg-offset-4 col-lg-1">
								<label for="nom">Nom magasin</label>
								</div>
								<div class="col-lg-1">
									<input type="text" name="nom" id="nom" /><br />
								</div>
							</div>
						<br>
						
						<div class="row">
							<div class="col-lg-offset-4 col-lg-1">
								<label for="num">Numero</label>
							</div>
							<div class="col-lg-1">
								<input type="number" name="num" id="num" /><br />
							</div>
						</div>
						<br>
						
						<div class="row">
							<div class="col-lg-offset-4 col-lg-1">
								<label for="rue">Rue</label>
							</div>
							<div class="col-lg-1">
								<input type="text" name="rue" id="rue" /><br />
							</div>
						</div>
						<br>
						
						<div class="row">
							<div class="col-lg-offset-4 col-lg-1">
								<label for="ville">Ville</label>
							</div>
							<div class="col-lg-1">
								<input type="text" name="ville id=ville" /><br />
							</div>
						</div>
						<br>
						
						<div class="row">
							<div class="col-lg-offset-4 col-lg-1">
								<label for="cd">Code postal</label>
							</div>
							<div class="col-lg-1">
								<input type="text" name="cd" id="cd" /><br />
							</div>
						</div>
						<br>
						
						<div class="row">
							<div class="col-lg-offset-4 col-lg-1">
								<label for="desc">Description</label>
							</div>
							<div class="col-lg-1">
								<textarea name="desc" rows="5" cols="50" > Description </textarea> 
							</div>
						</div>
						<br>
						
						<div class="row">
							<div class="col-lg-offset-4 col-lg-1">
								<label for="tel">Tel</label>
							</div>
							<div class="col-lg-1">
								<input type="number" name="tel" id="tel" /><br />
							</div>
						</div>
						<br>
			
						<div class="row">
							<div class="col-lg-offset-4 col-lg-1">	
								<input type="submit" value="Valider"/>
							</div>
							<div class="col-lg-1">
							</div>
						</div>
						<br>
					</form>';
		}
	}

?>