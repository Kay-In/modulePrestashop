<!-- Block ky_monmodule -->
<div id="ky_monmodule_block_home" class="block">
    <h4>{l s='Message du jour' d='Modules.Ky_MonModule'}</h4>
    <div class="block_content">
        <div class="messagedefilant">
            <div data-text="{$ns_page_name}">
                <span>
                    <!--j'utilise la balise marquee meme si deprecié parce que toutes les autres tentatives en css ou js ne fonctionnnait pas-->
                    {* <marquee direction="left"> *}
                    {if isset($ns_page_name)&& $ns_page_name}
                        {$ns_page_name}
                    {else}
                        Votre message
                    {/if}
                    {* </marquee> *}
                </span>
            </div>
        </div>
    </div>
    <style>
        /* #ky_monmodule_block_home {
            box-shadow: 2px 2px 8px 0 rgba(0, 0, 0, .2);
            background: #fff;
            padding: 1.563rem 1.25rem;
            margin-bottom: 1.563rem;
        }*/


        /* Texte défilant */

        .messagedefilant {
            display: block;
            margin: 40px auto;
            padding: 0;
            overflow: hidden;
            position: relative;
            width: 100%;
            max-width: 640px;
            height: 100px;
        }

        .messagedefilant div {
            position: absolute;
            min-width: 100%;
            /* au minimum la largeur du conteneur */
        }

        .messagedefilant div span,
        .messagedefilant div:after {
            position: relative;
            display: inline-block;
            font-size: 2rem;
            white-space: nowrap;
            top: 0;
        }

        .messagedefilant div span {
            animation: defilement 10s infinite linear;
            background: #cde;
        }

        .messagedefilant div:after {
            position: absolute;
            top: 0;
            left: 0;
            content: attr(data-text);
            animation: defilement2 10s infinite linear;
            background: #edc;
        }

        @keyframes defilement {
            0% {
                margin-left: 0;
            }

            100% {
                margin-left: -100%;
            }
        }

        @keyframes defilement2 {
            0% {
                margin-left: 100%;
            }

            100% {
                margin-left: 0%;
            }
        }

        span {
            color: green
        }
    </style>
<!-- /Block ky_monmodule-->