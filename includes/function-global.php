<?php

//****************** PAGINATION ******************//
function pagination($url, $param='?page=%d', $current_page, $nb_pages, $around=3, $firstlast=2)
{
    $pagination = '';
    if ( !preg_match('/%d/', $param) ) $param .= '%d';
    if ( $nb_pages > 1 ) {
	
		    $pagination .= "<div class=\"pagination\">\n";

        // Lien précédent
		if ($current_page == 2) // la page courante est la 2, le bouton renvoit donc sur la page 1, remarquez qu'il est inutile de mettre ?p=1
            $pagination .= '<a class="page gradient" href="'.$url.'">&laquo; Précédent</a>';
        elseif ( $current_page > 2 )
            $pagination .= '<a class="page gradient" href="'.sprintf($param, $current_page-1).'" title="Page pr&eacute;c&eacute;dente">&laquo; Précédent</a>';
        else
            $pagination .= '<span class="page gradient disabled">&laquo; Pr&eacute;c&eacute;dent</span>';

        // Lien(s) début	
        for ( $i=1; $i<=$firstlast; $i++ ) {
            $pagination .= ' ';
			if ( $i==1 )
			$pagination .= ($current_page==1) ? '<span class="page active">'.$i.'</span>' : '<a class="page gradient" href="'.$url.'">'.$i.'</a>';
			else
            $pagination .= ($current_page==$i) ? '<span class="page active">'.$i.'</span>' : '<a class="page gradient" href="'.sprintf($param, $i).'">'.$i.'</a>';
        }

        // ... après pages début ?
        if ( ($current_page-$around) > $firstlast+1 )
            $pagination .= '<span class="page gradient">&hellip;</span>';

        // On boucle autour de la page courante
        $start = ($current_page-$around)>$firstlast ? $current_page-$around : $firstlast+1;
        $end = ($current_page+$around)<=($nb_pages-$firstlast) ? $current_page+$around : $nb_pages-$firstlast;
        for ( $i=$start ; $i<=$end ; $i++ ) {
            $pagination .= ' ';
            if ( $i==$current_page )
                $pagination .= '<span class="page active">'.$i.'</span>';
            else
                $pagination .= '<a class="page gradient" href="'.sprintf($param, $i).'">'.$i.'</a>';
        }

        // ... avant page nb_pages ?
        if ( ($current_page+$around) < $nb_pages-$firstlast )
            $pagination .= '<span class="page gradient">&hellip;</span>';

        // Lien(s) fin
        $start = $nb_pages-$firstlast+1;
        if( $start <= $firstlast ) $start = $firstlast+1;
        for ( $i=$start ; $i<=$nb_pages ; $i++ ) {
            $pagination .= ' ';
            $pagination .= ($current_page==$i) ? '<span class="page active">'.$i.'</span>' : '<a class="page gradient" href="'.sprintf($param, $i).'">'.$i.'</a>';
        }

        // Lien suivant
        if ( $current_page < $nb_pages )
            $pagination .= ' <a class="page gradient" href="'.sprintf($param, ($current_page+1)).'" title="Page suivante">Suivant &raquo;</a>';
        else
            $pagination .= ' <span class="page gradient disabled">Suivant &raquo;</span>';
			
			$pagination .= "</div>\n";
    }
	
    return $pagination;
}