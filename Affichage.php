<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php
    function menu(){
        $tab_menu_link = array( "PromoSphere.php", "PromoSphere.php?a=SignalerProm", "PromoSphere.php?a=toutePromo", "PromoSphere.php?a=AfficherPanier");
        $tab_menu_txt = array( "Accueil", "Signaler une promotion", "Les promotions", "Liste de shopping");
        $menu="";
        $info = pathinfo($_SERVER['PHP_SELF']);
        
        foreach($tab_menu_link as $cle=>$lien){
            $menu .= "   <li";
            
            if($info['basename'] == $lien){
                $menu .=" class=\"active\"";
            }
                
            $menu .= "><a href=\"" . $lien . "\">" . $tab_menu_txt[$cle] . "</a></li>\n";
            
        }
        
        return $menu;
    }
?>


<?php

	include_once 'Article.php';
	include_once 'liste.php';
	include_once 'Client.php';
	include_once 'Magasin.php';
	
	class Affichage{

		public static function BarreNav(){         
		   require_once("./Affichage.php");
           $menu = menu();
            
           echo'<nav class="navbar navbar-inverse" role="navigation" >
					<div class="row">
          <div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-offset-1 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                    <div class = "col-lg-9 col-md-9 col-sm-9 col-xs-9">
                    
						<img id="logo" src="inQontrol_qdance.png" style="max-height:75px; max-width:75px; float:left;"/>
                        <h1 class="col-lg-3  col-md-3 col-sm-3 col-xs-3" style="color:red;">Promo Sphère</h1>
                        <div class="col-md-offset-1 col-sm-offset-1 col-xs-offset-1 col-lg-offset-1 col-lg-7  col-md-7 col-sm-7 col-xs-7" style="margin-top:1%">
                        <ul class="nav navbar-nav">';
                        echo $menu;
						if(isset($_SESSION['profil']['com'])){
			echo'			<li >
								<a href="PromoSphere.php?a=Ajoutmag">Ajouter magasin</a>
							</li>';
						}
			echo'			</ul> 
            </div>
                        
                        
					</div>';
					
			if(isset($_SESSION['profil'])){
				echo	'	<div class="col-lg-2  col-md-2 col-sm-2 col-xs-2">
                            <br>
							<div class="col-lg-6  col-md-6 col-sm-6 col-xs-6"><p id="connecte">Bonjour ' . $_SESSION['profil']['prenom'] .'</p></div>
							<a class="col-lg-6  col-md-6 col-sm-6 col-xs-6" href="PromoSphere.php?a=Deconnexion"><p class="log">Deconnexion</p></div></a>

						</div>
                        </div>
					</nav>';	
			}else{
				echo	'	<div class="col-lg-2  col-md-2 col-sm-2 col-xs-2">
              <br>
							<a class="col-lg-6  col-md-6 col-sm-6 col-xs-6" href="PromoSphere.php?a=Connexion"><p class="log">Se connecter</p></a>
							<a class="col-lg-6 col-md-6 col-sm-6 col-xs-6" href="PromoSphere.php?a=Inscription"><p class="log">S\'inscrire</p></a>
						</div>
            </div>
					</nav>';
			}
		}
		
		
		public static function Accueil(){

      echo ' <div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-offset-1 col-lg-10 col-md-10 col-sm-10 col-xs-10">
      <div id="lastProd">Les derniers produits signalés...</div><br></div><div>';
			Affichage::AfiAll();
			
		$b = Base::getConnection();
			$save_query = "DELETE FROM events WHERE date < CURDATE();";
			try{
				$stmt = $b->prepare($save_query);
				$a = $stmt->execute();
				return $a;
			}catch (PDOException $e){
				return null;
			}
      echo '</div>';

		}
		
		public static function Connexion(){
			
			echo '<div>';
				echo '<form action="Connexion.php" method="post">
                    <div class="row">
                        <br><br><br>
                        <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-2 col-xs-offset-2 col-lg-8  col-md-8 col-sm-8 col-xs-8">
					            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label for="Login">Login</label>
                                </div>
					            <input type="text" name="login" value=""/><br><br>

                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					                <label for="mdp">Mot de passe</label>
                                </div>    
					            <input type="password" name="mdp" value=""/><br><br>

					            <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4"><input type="submit" value="Se connecter"/ class="btn btn-primary"></div>
                            </div>    
                        </div>
                    </div>
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
			echo '<div class="row"><br><br><br>
                    <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-4 col-md-4 col-sm-4 col-xs-4"><div class="col-lg-offset-2 col-lg-8 col-md-8 col-sm-8 col-xs-8">
			        <form action="Inscription.php" method="post">
			
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
				        <label for="Login">Login</label>
                    </div>
				    <input type="text" name="login" value=""/><br><br>
				
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
				        <label for="mdp">Mot de passe</label>
                    </div>
				    <input type="password" name="mdp" value=""/><br><br>
				
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
				        <label for="prenom">Prenom</label>
                    </div>
				    <input type="text" name="prenom" value=""/><br><br>
					
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
				        <label for="nom">Nom</label>
                    </div>
				    <input type="text" name="nom" value=""/><br><br>

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
				        <label for="email">Email</label>
                    </div>
				    <input type="text" name="email" value=""/><br><br>
					
					<td><b>Type</b></td>  
					<td><input type=radio value="particulier" name="type" id="particulier" required/>Particulier
					  <input type=radio value="commercant" name="type" id="commercant required">Commercant
					  </select>
					</td>
					
					<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4">
					<input type="submit" value="S inscrire"  "class="btn btn-primary"/></div>
				    </form>
                    </div></div>
			    </div>';
		}
		
		public static function Afi($art){
			echo '  <div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-offset-1 col-lg-10 col-md-10 col-sm-10 col-xs-10" style="border-style:solid; border-radius: 5px; box-shadow: 5px 5px 15px black;">	 
						<div class="row" style="background:#F0EAE7;">
							<div class="bigbox">
								<h2 class="col-lg-offset-2 col-md-offset-2 col-sm-offset-2 col-xs-offset-2 col-lg-2 col-md-2 col-sm-2 col-xs-2">'. $art->nom_article .'</h2>                      
								<div class="row"> <!-- box affichant les informations du produit -->
									<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-8 col-md-8 col-sm-8 col-xs-8">             
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3" >
											<br><br>
											<img class="img-circle img-responsive" src="'. $art->photo .'" />
										</div>  <!-- fin de div contenant img --> 
										<div class="col-lg-offset-3 col-md-offset-3 col-sm-offset-3 col-xs-offset-3 col-lg-5 col-md-5 col-sm-5 col-xs-5" style="border-style:solid; border-radius: 5px; box-shadow: 5px 5px 15px black; background:#B8ABA5;">
											<div class="descr-box" style="font-size:inherit; text-shadow:inherit; font-weight:bolder;">
												<br>
												<div class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Prix: <del>'. $art->prix .'</del></div>
												</div>										
												<div class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Prix promo :'. $art->prix_promo .'</div>
												</div><br>';
												
			if(isset($_SESSION['profil'])){
				$count = liste::countArtById($_SESSION['profil']['userid']);
					if($count['nombre']  == 0){
						echo'					<a href="PromoSphere.php?a=addLs&idart='. $art->id_article .'"><button class="btn btn-primary">Ajouter à la liste</button></a>';
					}else{
						echo'					<a href="PromoSphere.php?a=supLs&idart='. $art->id_article .'"><button class="btn btn-primary">Retirer de la liste</button></a>';
					}
			}else{
				echo'							<a href="PromoSphere.php?a=addLs&idart='. $art->id_article .'"><button class="btn btn-primary">Ajouter a la liste</button></a>';
			}
			$mag = new Magasin();
			$mag = Magasin::findById($art->id_magasin);
									
			if($art->id_client != null){
			    $cli = new Client();
			    $cli = Client::findById($art->id_client);
			     echo '							<br> Mise en ligne par <b>'. $cli->login_client .'</b>.';
			}else{
				if($art->id_magasin != null){
					echo '						<br> Mise en ligne par <b>☆'. $mag->nom_magasin .'</b>.';
				}
			}
                                  
			echo'								<a href=PromoSphere.php?a=modifProm&idart='. $art->id_article .'>
												<div class="row"><br>
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><button class="btn btn-primary">Modifier la promotion</button></div>
												</div>
												</a>
												<br>Période promotion: '. $art->datedebut .' au '. $art->datefin.'
												<div class="row"><br>';
                                           
			if($art->id_magasin != null){
				echo ' 								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> Ce produit est disponible à '. $mag->nom_magasin .'</div>
												</div>
												<div class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Au '. $mag->numero .', '. $mag->rue .', '. $mag->ville .'</div>
												</div>';
			}else{
				echo ' 								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
												</div>
												<div class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
												</div>';								
			}
												 
			echo' 								<div class="row"><br>
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Ce bon plan n\'existe plus ? <a href="PromoSphere.php?a=supProm&idart='. $art->id_article .'"><button class="btn btn-primary">Supprimer</button> </a>
														<div>
															<br>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<hr />
								<div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-2 col-xs-offset-2 col-lg-8 col-md-8 col-sm-8 col-xs-8">
									<div class="descr-box">Description : '.	$art->description.' <br>
										Taille(s): '. $art->taille_dispo .
										'<br>'. 'Couleur: '. $art->couleur .'<br><br>
									</div>
								</div>
								<br><br>
							</div>
						</div>
					</div>';
		}
		
		public static function AfiAll(){
            echo'<div class="row">
                    <div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-offset-1 col-lg-10 col-md-10 col-sm-10 col-xs-10">';
				foreach (Article::findAll() as $art) {
					Affichage::Afi($art);
                    echo'<div class="row"><div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-offset-1 col-lg-10 col-md-10 col-sm-10 col-xs-10"><hr / style="visibility:hidden;"></div></div>';
				}
            echo'</div></div>';    
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
					echo '<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-6 col-md-6 col-sm-6 col-xs-6">Votre liste est vide</div>';
				}
				
			}
		
		}
		
		public static function AjoutListe($idart){
				liste::ajoute($idart,$_SESSION['profil']['userid']);
		}
		
		
		public static function NouvelPromo(){
			echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
			echo '	<form action="NvPromo.php" method="post" enctype="multipart/form-data">
			  
						<div class="row">
							<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-2 col-md-2 col-sm-2 col-xs-2"><div id="lastProd">Ajouter un bon plan :</div></div><br><br><br>
								<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
									<label for="cbarre">code barre</label>
								</div>
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
									<input type="text" name="cbarre" value=""/>
								</div>
							</div>
							<br><br>
				
							<div class="row">
								<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
									<label for="narticle">Nom de l\'article</label>
								</div>
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
									<input type="text" name="narticle" value=""/>
								</div>
							</div>
							<br><br>
				
							<div class="row">
								<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
									<label for="prix">Prix origine</label>				
								</div>
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
									<input type="text" name="prix" value=""/>
								</div>
							</div>
							<br><br>
				
							<div class="row">
								<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
									<label for="prixprom">Prix promotion</label>
								</div>
								<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">	
									<input type="text" name="prixprom" value=""/>
								</div>
							</div>
							<br><br>
				
							<div class="row">
								<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
									<label for="desc">Description</label>
								</div>
								<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
									<textarea name="desc" rows="5" cols="50" > </textarea> 
								</div>
						</div>
						<br>
				
						<div class="row">
							<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<label for="image">Image produit</label>					
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<input type="file" name="photo"/>
							</div>
						</div>
						<br><br>
				
						<div class="row">
							<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<label for="taille">Taille disponible</label>			
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<input type="text" name="taille" value=""/>
							</div>
						</div>
						<br><br>
				
						<div class="row">
							<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
									<label for="couleur">Couleur</label>			
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<input type="text" name="couleur" value=""/>
							</div>
						</div>		
						<br><br>
				
						<div class="row">
							<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<label for="datedeb">Date début</label>				
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<input type="date" name="datedeb">
							</div>
						</div>
						<br><br>
				
						<div class="row">
							<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<label for="datefin">Date fin</label>
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<input type="date" name="datefin">
							</div>
						</div>
						<br>';		
			if(isset($_SESSION['profil']['com'])){
						
				echo'		<label for="magasin">Magasin ?</label><br />
							<select name="magasin" id="magasin">';
								
				foreach(Magasin::finByIdCom($_SESSION['profil']['userid']) as $mag){
					echo'	<option value="'.$mag->nom_magasin.'">'. $mag->nom_magasin .'</option>';
				}
				
				echo '		</select>				
							<div class="row">
								<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">				
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<input type="submit" onclick="verif_INF(prix,prixprom)" value="Valider promo" class="btn btn-primary"/>
							</div>
						</div>
					</form>
				</div>';
			}
		}
		
		public static function ModifPromo($art){
            echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
			echo '<form action="ModifPromo.php?idart='.$art->id_article.'" method="post">
			
                <div class="row">
                <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">	
				<label for="cbarre">code barre</label>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
				<input type="text" name="cbarre" value="'.$art->code_barre.'"/>
				<br><br>
                </div>
                </div>
				
                <div class="row">
                <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">	
				<label for="narticle">Nom de l\'article</label>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
				<input type="text" name="narticle" value="'.$art->nom_article.'"/>
				<br><br>
                </div>
                </div>
				
                <div class="row">
                <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">	
				<label for="prix">Prix origine</label>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
				<input type="text" name="prix" value="'.$art->prix.'"/>
				<br><br>
                </div>
                </div>
					
                <div class="row">
                <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">	
				<label for="prixprom">Prix promotion</label>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
				<input type="text" name="prixprom" value="'.$art->prix_promo.'"/>
				<br><br>
                </div>
                </div>
				
                <div class="row">
                <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">	
				<label for="desc">Description</label>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
				<textarea name="desc" rows="5" cols="50" >'.$art->description.' </textarea> 
				<br>
                </div>
                </div>
				
                <div class="row">
                <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">	
				<label for="image">Image produit</label>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
				<input type="file" name="photo">'.$art->photo.' </> 
				<br><br>
                </div>
                </div>
				
                <div class="row">
                <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">	
				<label for="taille">Taille disponible</label>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
				<input type="text" name="taille" value="'.$art->taille_dispo.'"/>
				<br><br>
                </div>
                </div>
				
				<div class="row">
                <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">	
				<label for="couleur">Couleur</label>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
				<input type="text" name="couleur" value="'.$art->couleur.'"/>
				<br><br>
                </div>
                </div>
				
                <div class="row">
                <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">	
				<label for="datedeb">Date début</label>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
				<input type="date" name="datedeb"> '.$art->datedebut.' </>
				<br><br>
                </div>
                </div>
				
                <div class="row">
                <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">	
				<label for="datefin">Date fin</label>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
				<input type="date" name="datefin"> '.$art->datefin.' </>
				<br>
                </div>
                </div>

                <div class="row">
                <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
                </div>
                 <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
				<input type="submit" value="Valider promo" class="btn btn-primary"/>
                </div>
                </div>
				</form>';
			echo '</div>';
		}
		
		public static function Ajoutmag(){
			echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
			echo'	<form method="post" action="Nvmag.php">
						
						<div class="row">
							<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<label for="nom">Nom magasin</label>
								</div>
								<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
									<input type="text" name="nom" id="nom" /><br />
								</div>
							</div>
						<br>
						
						<div class="row">
							<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<label for="num">Numero</label>
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<input type="number" name="num" id="num" /><br />
							</div>
						</div>
						<br>
						
						<div class="row">
							<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<label for="rue">Rue</label>
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<input type="text" name="rue" id="rue" /><br />
							</div>
						</div>
						<br>
						
						<div class="row">
							<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<label for="ville">Ville</label>
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<input type="text" name="ville" id="ville" /><br />
							</div>
						</div>
						<br>
						
						<div class="row">
							<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<label for="cd">Code postal</label>
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<input type="text" name="cd" id="cd" /><br />
							</div>
						</div>
						<br>
						
						<div class="row">
							<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<label for="desc">Description</label>
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<textarea name="desc" rows="5" cols="50" > Description </textarea> 
							</div>
						</div>
						<br>
						
						<div class="row">
							<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<label for="tel">Tel</label>
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<input type="number" name="tel" id="tel" /><br />
							</div>
						</div>
						<br>
			
						<div class="row">
							<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">	
								<input type="submit" value="Valider"/>
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
							</div>
						</div>
						<br>
					</form>';
		}
	}

?>