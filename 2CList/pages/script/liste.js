//GERE LES EVENNEMENTS QUI SUIVE UNE ACTION EFFECTUE SUR LES BOUTONS DE LISTE
var globalListe = {
        reponseAjax : "",
        indice:"",
};

//fonction lancee au demarrage de la page
$(document).ready(function()
{
});
//EVENT_PRESENT_DANS_HTML____________________________________________________________________________________________________
function liste()
{
    //evite que les liens redirige ou recharge la page
    $('a').click(function(e)
    {
        e.preventDefault();
    });

    //recupere les informations necessaires au traitement AJAX
    var vo_tabClass =(event.target.className).split(' ') ;
    var vn_id =parseInt(event.target.attributes.name.value) ;

    //examine les classes des bouton que l'on a clique pour determiner quelle est la liste qu'il faut mettre a jour
    var vn_typeList ;
    var vn_class;

    for(var i= 0; i< vo_tabClass.length; i++)
    {
        if( vo_tabClass[i] === "btn-avoir"  ||  vo_tabClass[i] === "icon-avoir"||  vo_tabClass[i] === "avoir")
        {
            vn_typeList='avoir';
            vn_class = "btn-avoir";
            break;
        }
        if( vo_tabClass[i] === "btn-fav" ||  vo_tabClass[i] === "icon-fav"||  vo_tabClass[i] === "favoris")
        {
            vn_typeList='favoris';
            vn_class = "btn-fav";

            break;
        }
        if( vo_tabClass[i] === "btn-vue" ||  vo_tabClass[i] === "icon-vue"||  vo_tabClass[i] === "vue")
        {
            vn_typeList='vue';
            vn_class = "btn-vue";

            break;
        }
    }

    //renvoie les informations determinees precement pour commencer le traitement ajax
    ajaxAddList(vn_typeList,vn_id,vn_class);

    //reactive les liens
    $('a').click(function()
    {
        $('a').unbind('click');
    });
}
//AJAX_____________________________________________________________________________________________________________________
function ajaxAddList(typeList,idfilm,vn_class)
{
    //recupere l'etat de la bdd concernant l'user , la liste et le film selectionne
    $.post
    (
        './metier/addlist.php',
        {
            liste : typeList,
            idfilm : idfilm,
        },
        function(data){
            //stocke dans une variable globale la reponse
            globalListe.reponseAjax=data;

            //met a jout le tooltip rattache au bouton clique pour avertir le user des effets de son action
            updateTooltip(idfilm,vn_class );
        },
        'text'
    );
}
//REPONSE_________________________________________________________________________________________________________________

function updateTooltip(id,vn_class)
{
    //avertie le user que le film etait deja present dans cette liste
    if(globalListe.reponseAjax === "AlreadyPresent" )
    {
        $("."+vn_class+"[name='"+id+"']").attr("tooltip"+globalListe.indice+"","Déjà présent");
    }
    //avertie le user que le film a ete ajoute a cette liste
    else if(globalListe.reponseAjax === "updateList" )
    {
        $("."+vn_class+"[name='"+id+"']").attr("tooltip"+globalListe.indice+"","Ajouté à la liste");
    }
    //avertie l'user qu'il n'est pas connecte
    else if(globalListe.reponseAjax === "NotConnected" )
    {
        $("."+vn_class+"[name='"+id+"']").attr("tooltip"+globalListe.indice+"","Connectez vous!");
    }
}
