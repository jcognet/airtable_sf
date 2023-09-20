# Comment gérer les échanges fetch / ajax
1. Côté JS, créer un fichier qui gère l'import et qui sera inclus côté front (exemple : example.js)
2. Ce fichier fera appel à un fichier côté data pour récupérer les données (exemple : data/example.js) et pour afficher les données (exemple : ui/example)
3. Pour lancer, le loader, il suffit d'appeler showLoader('container_data'); avec container_data la zone javascript grisée. Pour le couper :  hideLoader('container_data');
4. Côté PHP, on passe un paramètre au controller afin qu'il ne renvoie que la zone ajax.
Exemple : table pour la liste des données importées.
