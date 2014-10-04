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
								<a href="PromoSphere.php?a=SignalerProm">Signaler une promotion</a>
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
							'<a href="PromoSphere.php?a=Deconnexion" id="inscription">Deconnexion</div></a>
						</div>
                        </div>
					</nav>';	
			}else{
				echo	'	<div class="col-lg-offset-1 col-lg-2">
              <br>
							<a class="col-lg-6" href="PromoSphere.php?a=Connexion" id="loggeur">Se connecter</a>
							<a class="col-lg-6" href="PromoSphere.php?a=Inscription" id="inscription">S\'inscrire</a>
						</div>
					</nav>';
			}
		}
		
		public static function Accueil(){
			echo 'ceci est une page d\'accueil';
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
				<input type="text" name="email" value=""/><br>
				
				<label for="particulier"> Particulier</label>
				<input type="radio" name="choix" value="0"/>
				
				<label for="commerçant"> Commerçant</label>
				<br><input type="radio" name="choix" value="1"/>';
				 
				
				echo'<br><label><input type="submit" value="S\'inscrire"/></label>
				</form>';
			echo '</div>';
		}
		
		public static function Afi($art){
			echo '<div id="pageActive">'; 	 
					echo	'<div id="item">
								<div id="nomProduit">'.
								$art->nom_article.'
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
										
									echo'	<button id="inpricebox">Modifier la promotion</button>
										<div id="localisation"> Ce produit est disponible à CarreJeans à 1500m</div>
										<div id="adresse">Au 15, Rue Du Marchand, Nancy.</div>
										<div id="suppr">
											<div>Ce bon plan n\'existe plus ? <a href="PromoSphere.php?a=supProm&idart='. $art->id_article .'"><button>Supprimer</button> </a></div>
										</div>
									</div>
								</div>';
						
								echo '<div id="imageProduit">
									<img src="'.$art->photo.'" />
								</div>
								<hr />
								<div id="descriptionProduit">';	
								echo 'En promotion du '. $art->datedebut .' au '. $art->datefin. '<br>';								
								echo 'taille: '. $art->taille_dispo .'<br>';
								echo 'couleur: '. $art->couleur .'<br>';

								echo 'ajouté par:'. $art->id_client .' <br><br><br><br><br>';
								echo $art->description;
								echo '</div>
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
			echo '<div class="col-lg-12">';
			echo '<form action="NvPromo.php" method="post">
			  
        <div class="row">
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
        <input type="submit" value="Valider promo"/>
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
	}
?>