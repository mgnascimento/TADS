<?php
/**
 * Created by PhpStorm.
 * User: tassio
 * Date: 09/01/2018
 * Time: 14:05
 */
echo "
<div class='main-panel'>
		<nav class='navbar navbar-default'>
            <div class='container-fluid'>
                <div class='navbar-header'>
                    <button type='button' class='navbar-toggle'>
                        <span class='sr-only'>Toggle navigation</span>
                        <span class='icon-bar bar1'></span>
                        <span class='icon-bar bar2'></span>
                        <span class='icon-bar bar3'></span>
                    </button>
                </div>
                <div class='collapse navbar-collapse'>
                    <ul class='nav navbar-nav navbar-right'>
                        <li>
                                <i class='ti-calendar'></i>
								<p>";
								    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                                    echo strftime('%A, %d de %B de %Y', strtotime('today'));
								echo "
                                </p>
                        </li>
						<li>
                            <a href='sair.php'>
								<i class='ti-'></i>
								<p>Sair</p>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>
";