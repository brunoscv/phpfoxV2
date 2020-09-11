<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* promotions.html */
class __TwigTemplate_f58e390781859c640896d507397990980406dc9c4d642540b408831d3221beef extends Core\View\Base
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        echo "<center><font size=6 ><b>MOVIE SYSTEM - FULL VERSION</font><br><font size=2 color=red>This is only a <b>display window</b> of the apps. To <b>buy</b> you must go <a href=\"../store/?load=apps\"><b>[HERE]</b></a> and search for <b>Movies System</b>.</font></center> 
<iframe src=\"https://store.phpfox.com/apps/movies-system-cespiritual\" style=\"position: relative; height: 800px; width:100%; border: none\"></iframe> 
";
    }

    public function getTemplateName()
    {
        return "promotions.html";
    }

    public function getDebugInfo()
    {
        return array (  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "promotions.html", "/Users/deskpropaganda/Sites/phpfoxV2/PF.Site/Apps/ces_movies/views/promotions.html");
    }
}
