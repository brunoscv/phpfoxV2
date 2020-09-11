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

/* @ces_members_in_your_state/index.html */
class __TwigTemplate_508bf5feb80985e22f46bda7706f54aed29edec6191aea5c0c89c0c8ed6a1cbc extends Core\View\Base
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
        echo "<div class=\"block \">
\t<div class=\"title\">
\t";
        // line 3
        echo call_user_func_array($this->env->getFunction('_p')->getCallable(), ["In your State"]);
        echo "
\t</div>
\t<div class=\"content\">
\t
";
        // line 7
        echo ($context["content"] ?? null);
        echo "

\t</div>
</div><br>";
    }

    public function getTemplateName()
    {
        return "@ces_members_in_your_state/index.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  41 => 7,  34 => 3,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "@ces_members_in_your_state/index.html", "/Users/deskpropaganda/Sites/phpfoxV2/PF.Site/Apps/ces_members_in_your_state/views/index.html");
    }
}
