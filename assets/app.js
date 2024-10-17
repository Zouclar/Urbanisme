// assets/app.js

// Import jQuery
const $ = require('jquery');
global.$ = global.jQuery = $;

// Import Bootstrap
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';

// Import DataTables
import 'datatables.net';
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';

// Initialize DataTables
$(document).ready(function() {
    $('#table').DataTable( {
        paging: false,
        autoFill: true,
        language: {
            decimal: "",
            emptyTable: "Aucune donnée disponible dans le tableau ¯\\_(ツ)_/¯",
            info: "Affichage de l'entrée _START_ à _END_ sur _TOTAL_ entrées",
            infoEmpty: "Affichage de l'entrée 0 à 0 sur 0 entrées",
            infoFiltered: "(filtrées à partir de _MAX_ entrées au total)",
            infoPostFix: "",
            thousands: ",",
            lengthMenu: "Afficher _MENU_ entrées",
            loadingRecords: "Chargement...",
            processing: "",
            search: "Rechercher :",
            zeroRecords: "Aucun enregistrement correspondant trouvé ¯\\_(ツ)_/¯",
            paginate: {
                "first": "Premier",
                "last": "Dernier",
                "next": "Suivant",
                "previous": "Précédent"
            },
            aria: {
                "orderable": "Trier par cette colonne",
                "orderableReverse": "Inverser le tri de cette colonne"
            }
        },
        columnDefs: [
            {
                targets: -1, // Cible la dernière colonne (assurez-vous que "actions" est bien la dernière colonne)
                orderable: false // Rend la colonne non triable
            }
        ]
    } );
});