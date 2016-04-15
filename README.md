# UCC - Ultimate Character Championship
## Semaine intensive API @ HETIC

###Projet :
UCC est un système de jeu sous forme de poules qui met en place tous les quatre jours un tournoi opposant des personnages de films. Pour voter, l'utilisateur n'a besoin que d'un compte twitter. Chaque tournoi est basé sur un thème précis (robots, personnages d'anime). Pendant chaque tournoi, l'utilisateur peut aussi voter pour choisir quel thème sera le prochain. 


###Utilisation utilisateur :
Chaque tournoi est composé de 16 personnages. Le tournoi commence systématiquement aux 8e de finales et un round dure 24h.
A chaque round, l'utilisateur peut voter pour tous les matches disponibles. Par exemple, lors de 8e de finale, il y aura 8 différents votes disponibles.
Grâce à la page Results, l'utilisateur peut d'un simple coup d'oeil visualiser l'ensemble du tournoi et son avancement.
A la fin de chaque journée, les votes sont compatibilisés et le tournoi passe au round suivant.
Une page Archive recense tous les tournois précédents.

###Utilisation administrateur :
Une interface administrateur est disponible. Elle permet à l'admin de chercher dans la BDD The Movie Database un mot-clé précis. Suite à cela, est ressortie une liste de films correspondant à ce mot-clé et ses personnages. Il peut ainsi facilement déterminer qui seront les personnages du prochain tournoi. Il peut aussi créer le prochain sondage et choisir les prochains thèmes.

###Twitter Bot :
Un bot Twitter est en ligne @UCC_BOT. A la fin de chaque round, il poste automatiquement un récapitulatif de la journée passée.

###Features :
 - Twitter connect
 - Bot twitter
 - Vote pour chaque match
 - Vote pour le prochain thème
 - Une page Archives pour les tournois passés
 - Une page Results avec une vue d'ensemble du tournoi en cours
 - Une interface administrateru


###Groupe composé de :
- Alex Berneau - Chef de projet et front-developer
- Valérian Fauqueur - Lead back-developer
- Léonard Djamdian - Back-developer
- Brandon Collen - Lead designer
- Alexandra Cossid - Front-developer
