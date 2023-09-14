#======================DOCUMENTATION==============================
Cette API est Basic Cote securite, privilleges et toutes autres analyse pousees.
Elle est faite dans le but fournir des Informations de base a une application 
mobile faite en Flutter.
Elle est belle et bien en open source !

NB: base_url = "http://127.0.0.1:8000/api/"
    base_url est une variable creer dans l'environnement de Postman pour factorise 
    le l'url.
    Notice : toutes ces routes sont verifié avec Postman, mais vous êtes libre 
            de le faire avec autre logiciel comme Insomnia
    Informations : Les operations d'authentification et d'enregistrement ne neccessite 
                    pas une authentication mais les cles du corps de l'objet JSON sont obligatoire

    Obligation : pour toutes les operations, les cles du parametre body des requetes http ou https sont
                obligatoire.
    
    A Retenir : Categorie doit exister avant le produit 
#=========================== USAGE =================================
    # 1 AUTHENTIFICATION (fournisseur d'authentication : Json Web Token JWT)
        infos :
            - fournisseur d'authentication : Json Web Token JWT
            - token_type : bearer
            - expired_in : 120 seconds
            
        a - se connecter (login)
            url : {{base_url}}login
            cles body :pseudo, password

        b - se deconnecter (logout)
            url : {{base_url}}logout
            cles body : pas de corps

        c - l'utilisateur authentifier
            url : {{base_url}}connectedUser
            return : les informations de l'utilisateur sont retourner

    # 2 - RELATION : CATEGORIE
        a- ajout d'une categorie
            url : {{base_url}}categorie/storeCategorie 
            cles body: libelleCategorie

        b- afficher les categories
            url : {{base_url}}categorie/listeCategorie
            cles body : pas de body

        c- mise a jour categorie
            url : {{base_url}}categorie/updateCategorie
            cles body : id, libelleCategorie

        d- supprimer une categorie
            url : {{base_url}}categorie/deleteCategorie
            cles body : id

    # 3 - RELATION PRODUIT
        a- ajout d'un produit
            url : {{base_url}}produit/addProduit 
            cles body:designation,prix,lienImage,qte,status,categorie_id 


        b- afficher les produit
            url : {{base_url}}produit/listeProduit
            cles body : pas de body

        c- mise a jour produit
            url : {{base_url}}produit/updateProduit 
            cles body:id,designation,prix,lienImage,qte,status,categorie_id 

        d- supprimer une categorie
            url : {{base_url}}categorie/deleteProduit
            cles body : id

    # 4 - RELATION USER
    
        a- ajout d'un utilisateur
            url : {{base_url}}user/storeUser
            cles body:pseudo,password,genre,avatar

        b- afficher les utilisateur
            url : {{base_url}}user/listUser
            cles body : pas de body

        c- mise a jour utilisateur
            url : {{base_url}}user/updateUser 
            cles body:id,pseudo,password,genre,avatar 

        d- supprimer une utilisateur
            url : {{base_url}}user/deleteUser
            cles body : id