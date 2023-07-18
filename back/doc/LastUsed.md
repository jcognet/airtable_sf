# Comment gérer le fonctionnement "dernière utilisation"
1. Côté Airtable, ajouter un champ "datetime" _Date d'utilisation_ (attention, le format d'écriture est important).
2. Ajouter le trait LastUsedTrait au Value Object.
3. Ajouter l'appel dans le dernormalizer.
4. Appeler updateLastUsed de l'AbstractClient au bon endroit.
