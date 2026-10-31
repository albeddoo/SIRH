# AGENTS.md — Règles communes pour tout agent de développement

1. Au premier démarrage, vérifier le dossier racine, l'état Git et les fichiers présents. Le pack de documentation n'est pas une application existante. Si des fichiers applicatifs inattendus existent, les signaler et ne rien supprimer. Ne pas afficher de secrets présents dans les fichiers de configuration.
2. Préserver le code déjà présent. Ne jamais écraser, supprimer, déplacer ou réinitialiser un fichier sans expliquer l'impact et obtenir une approbation explicite.
3. Respecter le stack local PHP MVC personnalisé + MySQL/MariaDB + WampServer. Pas de Laravel, Symfony, React, Vue, Node.js, Cloudflare ou hosting sans décision explicite.
4. Lire seulement les consignes communes et les documents nécessaires à la phase demandée. Ne pas charger toutes les phases d'un coup.
5. Implémenter des fonctionnalités de bout en bout : vue, contrôleur, service métier, modèle/repository, validation, contrôle d'accès, tests et documentation.
6. Aucune requête SQL dans les vues ; aucune logique métier dans les templates.
7. Toute évolution de schéma passe par une migration versionnée, avec compatibilité et procédure de mise à jour locale.
8. Les dossiers `app`, `config`, `database`, `storage`, `vendor` et les fichiers `.env` ne doivent pas être directement accessibles depuis Apache. Le DocumentRoot doit viser `public/` si la configuration locale le permet.
9. Contrôler les fichiers téléversés : extension autorisée, MIME réel, taille, nom aléatoire, stockage privé, autorisation serveur à la lecture.
10. Ne pas envoyer de CV réel à un service externe. Aucun LLM cloud ou SMTP externe n'est activé par défaut.
11. Ne pas inventer les résultats. Marquer clairement `Simulation`, `Non configuré`, `Échec` ou `Non testé` lorsque c'est le cas.
12. Ne pas faire de commit, push, merge, reset, clean ou action destructive sans autorisation explicite.
13. À la fin de chaque phase, remplir le rapport de fin de phase et s'arrêter.
