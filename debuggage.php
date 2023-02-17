<?php

function debuggage(){

    global $prix; // Utilisation de la variable globale pour afficher la valeur de $prix
    echo '<script>console.log("prix (debug): ' . $prix . '")</script>';

    $debug_window = '


       <style>

       #debug-window{

           position: fixed;z-index: 9999;width: 30vw;top: 25%;left: 69%;border:5px solid red;height: 50vh;background-color: #000;color:#fff;font-family:monospace;padding:1rem;overflow-y:scroll;

       }

       </style>

       <div id="debug-window">';

   

       $debug_window .= '<div style="text-align:center;font-size:2rem;text-decoration:underline;margin-bottom:24px">Debuggage</div>';

       $debug_window .= '<ul>';

       $debug_window .= '<li>'.get_stylesheet_directory_uri().'</li>';

       $debug_window .= '<li>'.$prix.' €</li>';

   

       // Début Fonction

   

       // Fin Fonction

   

       $debug_window .= '</ul>';

       $debug_window .= '</div>';

   

       echo $debug_window;

   }

?>