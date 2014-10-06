<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php

	include_once 'Article.php';
	include_once 'liste.php';
	include_once 'Client.php';
	include_once 'Magasin.php';
	
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
			$a = new article();
			$a = Article::findById(Article::LastInsert()->id_article);
			Affichage::Afi($a);
		
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
			echo '<div class="col-lg-offset-1 col-lg-10" style="border-style:dashed;">'; 	 
					echo	'<div class="row">
								<h2 class="col-lg-offset-2 col-lg-2">'.
								$art->nom_article
								.'</h2>
								<div class="row"> <!-- box affichant les informations du produit -->
									<div class="col-lg-offset-8 col-lg-3" style="border-style:dashed;">
                  <br>
										<div class="row"><div class="col-lg-12">Prix: <del>'. $art->prix .'</del></div></div>';
										
									echo' <div class="row"><div class="col-lg-12">Prix promo :'. $art->prix_promo .'</div></div>';
									
									if(isset($_SESSION['profil'])){
										$count = liste::countArtById($_SESSION['profil']['userid']);
										if($count['nombre']  == 0){
											echo'	<a href="PromoSphere.php?a=addLs&idart='. $art->id_article .'"><button class="btn btn-primary">Ajouter a la liste</button></a>';
										}else{
											echo'	<a href="PromoSphere.php?a=supLs&idart='. $art->id_article .'"><button class="btn btn-primary">Retirer de la liste</button></a>';
										}
									}else{
										echo'	<a href="PromoSphere.php?a=addLs&idart='. $art->id_article .'"><button class="btn btn-primary">Ajouter a la liste</button></a>';
									}									
									
									echo '<br>période promotion: '. $art->datedebut .' au '. $art->datefin;
									
									if($art->id_client != null){
										$cli = new Client();
										$cli = Client::findById($art->id_client);
										echo '<br> Mise en ligne par <b>'. $cli->login_client .'</b>.';
									}
									if($art->id_magasin != null){
										$mag = new Magasin();
										$mag = Magasin::findById($art->id_magasin);
										echo '<br> Mise en ligne par <b>☆'. $mag->nom_magasin .'</b>.';
									}
										
									echo'	<div class="row"><br><div class="col-lg-12"><button class="btn btn-primary">Modifier la promotion</button></div></div>
										<div class="row"><br><div class="col-lg-12"> Ce produit est disponible à CarreJeans à 1500m</div></div>
										<div class="row"><div class="col-lg-12">Au 15, Rue Du Marchand, Nancy.</div></div>
										<div class="row">
                      <br>
											<div class="col-lg-12">Ce bon plan n\'existe plus ? <a href="PromoSphere.php?a=supProm&idart='. $art->id_article .'"><button class="btn btn-primary">Supprimer</button> </a><div><br></div></div>
										</div>
									</div>
								</div>';
						
								echo '<div class="col-lg-offset-4">
									<img src="'.$art->photo.'" />
								</div>
								<hr />
								<div class="col-lg-offset-2 col-lg-8">';							
									echo 'taille: '. $art->taille_dispo .'     /';
									echo '     couleur: '. $art->couleur .'<br>';
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
				$temp = 0;
				foreach(Liste::findArtByIdCli($_SESSION['profil']['userid']) as $lis){
					$a = new Article();
					$a = Article::findById($lis->id_article);
					Affichage::Afi($a);
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
	}

?>