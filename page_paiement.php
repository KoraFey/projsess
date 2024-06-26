<?php
require_once 'config.php';

function getUserCredits($userId, $pdo) {
    $stmt = $pdo->prepare("SELECT credits FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchColumn() ?? 0;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $userId = $_SESSION['user_id']; 

    if ($_POST['action'] == 'fetchCredits') {
        echo json_encode(['credits' => getUserCredits($userId, $pdo)]);
    } elseif ($_POST['action'] == 'processPayment') {
        $total = $_POST['total'];
        $credits = getUserCredits($userId, $pdo);

        if ($total <= $credits) {
            $newCredits = $credits - $total;
            $updateStmt = $pdo->prepare("UPDATE PMT SET `credits` = :credit WHERE `user_id` = :id");
            $stmt->bindParam(":credit", $newCredits);
            $stmt->bindParam(":id", $userId);
            $updateStmt->execute();
            echo json_encode(['success' => true, 'newCredits' => $newCredits]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Insufficient credits']);
        }
    }
    exit;
}

if ($gUserId === 0) {
    header('Location: login.php'); 
    exit;
}

$isAjaxRequest = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $creditAjoute = (int)($_POST['credit-ajoute'] ?? 0); 

    if ($creditAjoute > 0) {  
        $stmt = $pdo->prepare("UPDATE PMT SET credits = credits + ? WHERE user_id = ?");
        if ($stmt->execute([$creditAjoute, $gUserId])) {
            if ($stmt->rowCount() > 0) {
                $message = 'Crédits ajoutés avec succès!';
                if (!$isAjaxRequest) {
                    $stmt = $pdo->prepare("SELECT credits FROM PMT WHERE user_id = ?");
                    $stmt->execute([$gUserId]);
                    $result = $stmt->fetch();
                    $availableCredits = $result ? $result['credits'] : 0; 
                }
                echo $message;
            } else {
                echo 'Aucune mise à jour des crédits effectuée. Vérifiez l\'ID utilisateur.';
                echo $gUserId;
            }
        } else {
            echo 'Erreur lors de l\'ajout de crédits.';
        }
        exit;
    } else {
        echo 'Montant non pris en charge pour cette opération.';
        exit; 
    }
}

if (!$isAjaxRequest) {
    $stmt = $pdo->prepare("SELECT credits FROM PMT WHERE user_id = ?");
    if ($stmt->execute([$gUserId])) {
        $result = $stmt->fetch();
        $availableCredits = $result ? $result['credits'] : 0; 
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement sécurisé</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('images/money.jpeg');
            background-repeat: repeat;
            background-position: center center;
            background-attachment: fixed;
            background-size: cover;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h3>Paiement sécurisé</h3>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($message)): ?>
                            <div class="alert alert-success">
                                <?= htmlspecialchars($message) ?>
                            </div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <h4>Available Credits: <span id="availableCredits"><?= htmlspecialchars((string)$availableCredits) ?> $</span></h4>
                        </div>

                        <div id="responseMessage" class="alert" style="display: none;"></div>
                        <form id="formulaire-paiement" method="post">
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
                            <div class="mb-3">
                                <label for="credit-ajoute" class="form-label">Ajouter des crédits:</label>
                                <select class="form-select" id="credit-ajoute" name="credit-ajoute" required>
                                    <option value="10">10 $</option>
                                    <option value="20">20 $</option>
                                    <option value="50">50 $</option>
                                    <option value="100">100 $</option>
                                    <option value="250">250 $</option>
                                    <option value="500">500 $</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Ajouter crédits</button>
                        </form>
                                            </div> <!-- Fermeture de card-body -->
                    </div> <!-- Fermeture de card -->
                </div> <!-- Fermeture de col-md-6 -->
            </div> <!-- Fermeture de row justify-content-center -->
            
            <div class="row justify-content-center mt-3">
                <div class="col-md-6">
                    <button class="btn btn-secondary" onclick="retourIndex()">Retour</button>
                </div>
            </div>
        </div> <!-- Fermeture de container -->
    </div>

    <!-- Fenêtre modale pour les messages de confirmation -->
    <div id="modal-message" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalMessageTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMessageTitle">Confirmation de paiement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Votre paiement a été effectué avec succès !</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function retourIndex() {
            window.location.href = "index.php";  
        }
        document.getElementById("formulaire-paiement").addEventListener("submit", function(event) {
            event.preventDefault();
            var formData = new FormData(this);

            fetch('page_paiement.php', { 
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(text => {
                const responseMessage = document.getElementById('responseMessage');
                responseMessage.style.display = 'block';
                responseMessage.innerHTML = text;
                document.getElementById("availableCredits").textContent = 'New credit value here'; 
                this.reset(); 
            })
            .catch(error => {
                console.error('Error submitting form:', error);
            });
        });



    </script>
</body>
</html>