<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php

	include_once 'Article.php';
	include_once 'liste.php';
	
	class Affichage{

		public static function BarreNav(){
			echo '<nav class="navbar navbar-inverse" >
					<div class="row">
                    <div class = "col-lg-8">
                    
						<img id="logo" src="inQontrol_qdance.png" style="max-height:75px; max-width:75px; float:left;"/>
                        <h1 class="col-lg-3" style="color:red;">Promo Sphère</h1>
                        <ul class="nav navbar-nav">
				            <li class="active" style="min-height:75px;">
								<a href="PromoSphere.php">Acceuil</a>
							</li>
                        
							<li style="min-height:75px;">
								<a href="PromoSphere.php?a=SignalerProm">Signaler une promotion / un bon plan</a>
							</li>
				
							<li style="min-height:75px;">
								<a href="PromoSphere.php?a=toutePromo">Afficher toutes les promotions et bons plans</a>
							</li>
							<li style="min-height:75px;">
								<a href="PromoSphere.php?a=AfficherPanier">Afficher liste de shopping</a>
							</li>
						</ul>    
                        
						
                        
					</div>
                    
					';
					
			if(isset($_SESSION['profil'])){
				echo	'	<div class="col-lg-offset-1 col-lg-2">
							Bonjour ' . $_SESSION['profil']['prenom'] .
							'<a href="PromoSphere.php?a=Deconnexion" id="inscription">Deconnexion</div>
						</div>
                        </div>
					</nav>';	
			}else{
				echo	'	<div class="col-lg-offset-1 col-lg-2">
              <br>
							<a href="PromoSphere.php?a=Connexion" id="loggeur">Se connecter</a>
							<a href="PromoSphere.php?a=Inscription" id="inscription">S\'inscrire</a>
						</div>
					</nav>';
			}
		}
		
		
		public static function Accueil(){
			echo '<div class="row">
            <div class="col-lg-offset-1 col-lg-10">
                <div class="col-lg-12" style="border-style:dashed;">        
					<div class="row">
						<h2 class="col-lg-offset-2 col-lg-2">
						   Jean LeJeans
						</h2>
						<div class="row">
                            
                           
							    <div class="col-lg-offset-8 col-lg-3" style="border-style:dashed;">
                    <br>        
								    <div class="row"><div class="col-lg-12">Prix: <del>55€</del></div></div>
								    <div class="row"><div class="col-lg-12">Prix promo : 45€</div></div>
								    <div class="row"><div class="col-lg-12"> Ce produit est disponible à CarreJeans à 1500m</div></div>
								    <div class="row"><div class="col-lg-12">Au 15, Rue Du Marchand, Nancy.</div></div>
                    <div class="col-lg-offset-1 col-lg-11">
                    <br>
								    <button class="btn btn-primary">Ajouter a la liste</button>
								    <button class="btn btn-primary">Modifier la promotion</button>        
                    </div>
								    <div class="row"><div class="col-lg-12"><br><div>Ce bon plan n\'existe plus ? <button class="btn btn-primary">Supprimer</button></div></div>
							    </div> <!-- fin de div contenant information prix et adresse produit -->
                  <br>
					    </div> <!-- fin div row -->
                        <div class="col-lg-offset-4" >
							    <img class="img-circle" src="diesel-jean-larkee-regular-homme.jpg" style="max-width:350px; max-height:350px;" />
						</div>  <!-- fin de div contenant img -->
					</div> <!-- fin div row -->
					
						
						<hr />
						<div class="col-lg-offset-2 col-lg-8">		<!-- Description texte -->
							"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
						</div> <!-- fin div description -->
					</div> <!-- fin div col-lg-12 -->               
				</div> <!-- fin div col-lg-12 -->
                </div> <!-- fin div row -->';
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
			echo '<div id="pageActive">'; 	 
					echo	'<div id="item">
								<div id="nomProduit">
								Jean LeJeans
								</div>
								<div id="prixProduit">
									<div id="boxPrix">
										<div id="prixNor">Prix: <del>'. $art->prix .'</del></div>';
										
									echo' <div id="prixRemise">Prix promo :'. $art->prix_promo .'</div>';
									
									if(isset($_SESSION['profil'])){
										$count = liste::countArtById($_SESSION['profil']['userid']);
									
										if($count['nombre']  == 0){
											echo'	<a href="PromoSphere.php?a=addLs&idart='. $art->id_article .'"><button id="addListe">Ajouter a la liste</button></a>';
										}else{
											echo'	<a href="PromoSphere.php?a=supLs&idart='. $art->id_article .'"><button id="addListe">Retirer de la liste</button></a>';
										}
									}
									
									echo 'période promotion: '. $art->datedebut .'/'. $art->datefin;
										
									echo'	<button id="inpricebox">Modifier la promotion / le bon plan</button>
										<div id="localisation"> Ce produit est disponible à CarreJeans à 1500m</div>
										<div id="adresse">Au 15, Rue Du Marchand, Nancy.</div>
										<div id="suppr">
											<div>Ce bon plan n\'existe plus ? <a href="PromoSphere.php?a=supProm&idart='. $art->id_article .'"><button>Supprimer</button> </a></div>
										</div>
									</div>
								</div>';
						
								echo '<div id="imageProduit">
									<img src="data:png;base64,'.base64_encode($art->photo).'" />
								</div>
								<hr />
								<div id="descriptionProduit">'.																						
									$art->description
								.'</div>
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
				foreach(Liste::findArtByIdCli($_SESSION['profil']['userid']) as $lis){
					$a = new Article();
					$a = Article::findById($lis->id_article);
					Affichage::Afi($a);
				}
				
			}
		
		}
		
		public static function AjoutListe($idart){
				liste::ajoute($idart,$_SESSION['profil']['userid']);
		}
		
		public static function NouvelPromo(){
			echo '<div>';
			echo '<form action="NvPromo.php" method="post">
			
				<label for="cbarre">code barre</label>
				<input type="text" name="cbarre" value=""/>
				<br><br>
				
				<label for="narticle">Nom de l\'article</label>
				<input type="text" name="narticle" value=""/>
				<br><br>
				
				<label for="prix">Prix origine</label>
				<input type="text" name="prix" value=""/>
				<br><br>
					
				<label for="prixprom">Prix promotion</label>
				<input type="text" name="prixprom" value=""/>
				<br><br>
				
				<label for="desc">Description</label>
				<textarea name="desc" rows="5" cols="50" > Description </textarea> 
				<br>
				
				<label for="image">Image produit</label>
				<input type="file" name="photo" />
				<br><br>
				
				<label for="taille">Taille disponible</label>
				<input type="text" name="taille" value=""/>
				<br><br>
				
				<label for="datedeb">Date début</label>
				<input type="date" name="datedeb">
				<br><br>
				
				<label for="datefin">Date fin</label>
				<input type="date" name="datefin">
				<br>

				<input type="submit" value="Valider promo"/>
				</form>';
			echo '</div>';
		}
	}

?>