<?php
$gPublic = true;
require_once __DIR__.'/config.php';


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement sécurisé</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <header class="bg-primary text-white text-center py-3">
                        <h3 class="text-center">Paiement sécurisé</h3>
                            <img src="images/visa .png" alt="Votre image" class="votre-classe">

                    </div>
                                                <div class="mb-3">
                                <label for="type-carte" class="form-label">Type de carte:</label>
                                <select class="form-select" id="type-carte" name="type-carte" required>
                                    <option value="visa">Visa</option>
                                    <option value="mastercard">Mastercard</option>
                                </select>
                            </div>

                    <div class="card-body">
                        <form id="formulaire-paiement">
                            <div class="mb-3">
                                <label for="numero-carte" class="form-label">Numéro de carte:</label>
                                <input type="text" class="form-control" id="numero-carte" name="numero-carte" placeholder="1234 5678 9012 3456" required>
                            </div>
                            <div class="mb-3">
                                <label for="titulaire-carte" class="form-label">Titulaire de la carte:</label>
                                <input type="text" class="form-control" id="titulaire-carte" name="titulaire-carte" placeholder="John Doe" required>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="date-expiration" class="form-label">Date d'expiration:</label>
                                    <input type="text" class="form-control" id="date-expiration" name="date-expiration" placeholder="MM/AA" required>
                                </div>
                                <div class="col">
                                    <label for="code-cvv" class="form-label">Code CVV:</label>
                                    <input type="text" class="form-control" id="code-cvv" name="code-cvv" placeholder="123" required>
                                </div>
                            </div>
                            <div class="card-body">
                        <form id="formulaire-paiement">
                            <div class="mb-3">
                                <label for="credit-ajoute" class="form-label">Ajouter des crédits:</label>
                                <select class="form-select" id="credit-ajoute" name="credit-ajoute" required>
                                    <option value="10"> 10 $</option>
                                    <option value="20"> 50 $</option>
                                    <option value="50"> 100 $</option>
                                    <option value="50"> 250 $</option>
                                    <option value="50"> 500 $</option>
                                    <!-- Ajoutez d'autres options de crédits ici si nécessaire -->
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-paiement mt-3">Ajouter crédits</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <div class="col-md-6">
                <button class="btn btn-secondary" onclick="retourIndex()">Retour</button>
            </div>
        </div>
    </div>

    <!-- Fenêtre modale pour les messages de confirmation -->
    <div id="modal-message" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmation de paiement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Votre paiement a été effectué avec succès !</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Éviter la soumission du formulaire par défaut
        document.getElementById("formulaire-paiement").addEventListener("submit", function(event) {
            event.preventDefault();

            // Afficher la fenêtre modale de confirmation
            var modalMessage = new bootstrap.Modal(document.getElementById('modal-message'));
            modalMessage.show();

            // Effacer les champs du formulaire après confirmation
            document.getElementById("formulaire-paiement").reset();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function retourIndex() {
            window.location.href = "index.php"; // Remplacez "index.php" par le chemin  d'index
        }
    </script>
</body>
</html>
