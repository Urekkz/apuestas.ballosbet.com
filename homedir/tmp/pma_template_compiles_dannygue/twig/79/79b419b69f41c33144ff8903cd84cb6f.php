<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* table/find_replace/index.twig */
class __TwigTemplate_cd191ebac2ff31a96254d211a104aa74 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        yield "<ul class=\"nav nav-pills m-2\">
  <li class=\"nav-item\">
    <a class=\"nav-link disableAjax\" href=\"";
        // line 3
        yield PhpMyAdmin\Url::getFromRoute("/table/search", ["db" => ($context["db"] ?? null), "table" => ($context["table"] ?? null), "pos" => 0]);
        yield "\">
      ";
        // line 4
        yield PhpMyAdmin\Html\Generator::getIcon("b_search", _gettext("Table search"), false, false, "TabsMode");
        yield "
    </a>
  </li>

  <li class=\"nav-item\">
    <a class=\"nav-link disableAjax\" href=\"";
        // line 9
        yield PhpMyAdmin\Url::getFromRoute("/table/zoom-search", ["db" => ($context["db"] ?? null), "table" => ($context["table"] ?? null)]);
        yield "\">
      ";
        // line 10
        yield PhpMyAdmin\Html\Generator::getIcon("b_select", _gettext("Zoom search"), false, false, "TabsMode");
        yield "
    </a>
  </li>

  <li class=\"nav-item\">
    <a class=\"nav-link active disableAjax\" href=\"";
        // line 15
        yield PhpMyAdmin\Url::getFromRoute("/table/find-replace", ["db" => ($context["db"] ?? null), "table" => ($context["table"] ?? null)]);
        yield "\">
      ";
        // line 16
        yield PhpMyAdmin\Html\Generator::getIcon("b_find_replace", _gettext("Find and replace"), false, false, "TabsMode");
        yield "
    </a>
  </li>
</ul>

<form method=\"post\" action=\"";
        // line 21
        yield PhpMyAdmin\Url::getFromRoute("/table/find-replace");
        yield "\" name=\"insertForm\" id=\"find_replace_form\" class=\"ajax lock-page\">
  ";
        // line 22
        yield PhpMyAdmin\Url::getHiddenInputs(($context["db"] ?? null), ($context["table"] ?? null));
        yield "
  <input type=\"hidden\" name=\"goto\" value=\"";
        // line 23
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["goto"] ?? null), "html", null, true);
        yield "\">
  <input type=\"hidden\" name=\"back\" value=\"";
        // line 24
        yield PhpMyAdmin\Url::getFromRoute("/table/find-replace");
        yield "\">

  <div class=\"card\">
    <div class=\"card-header\">";
yield _gettext("Find and replace");
        // line 27
        yield "</div>

    <div class=\"card-body\">
      <div class=\"mb-3\">
        <label class=\"form-label\" for=\"findInput\">";
yield _gettext("Find:");
        // line 31
        yield "</label>
        <input class=\"form-control\" type=\"text\" value=\"\" name=\"find\" id=\"findInput\" required>
      </div>

      <div class=\"mb-3\">
        <label class=\"form-label\" for=\"replaceWithInput\">";
yield _gettext("Replace with:");
        // line 36
        yield "</label>
        <input class=\"form-control\" type=\"text\" value=\"\" name=\"replaceWith\" id=\"replaceWithInput\">
      </div>

      <div class=\"mb-3\">
        <label class=\"form-label\" for=\"columnIndexSelect\">";
yield _gettext("Column:");
        // line 41
        yield "</label>
        <select class=\"form-select\" name=\"columnIndex\" id=\"columnIndexSelect\">
          ";
        // line 43
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(range(0, (Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["column_names"] ?? null)) - 1)));
        foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
            // line 44
            yield "            ";
            $context["type"] = (($__internal_compile_0 = ($context["types"] ?? null)) && is_array($__internal_compile_0) || $__internal_compile_0 instanceof ArrayAccess ? ($__internal_compile_0[(($__internal_compile_1 = ($context["column_names"] ?? null)) && is_array($__internal_compile_1) || $__internal_compile_1 instanceof ArrayAccess ? ($__internal_compile_1[$context["i"]] ?? null) : null)] ?? null) : null);
            // line 45
            yield "
            ";
            // line 46
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["sql_types"] ?? null), "getTypeClass", [($context["type"] ?? null)], "method", false, false, false, 46) == "CHAR")) {
                // line 47
                yield "              <option value=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["i"], "html", null, true);
                yield "\">";
                // line 48
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($__internal_compile_2 = ($context["column_names"] ?? null)) && is_array($__internal_compile_2) || $__internal_compile_2 instanceof ArrayAccess ? ($__internal_compile_2[$context["i"]] ?? null) : null), "html", null, true);
                // line 49
                yield "</option>
            ";
            }
            // line 51
            yield "          ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 52
        yield "        </select>
      </div>

      <div class=\"form-check\">
        <input class=\"form-check-input\" type=\"checkbox\" name=\"useRegex\" id=\"useRegex\">
        <label class=\"form-check-label\" for=\"useRegex\">";
yield _gettext("Use regular expression");
        // line 57
        yield "</label>
      </div>
    </div>

    <div class=\"card-footer\">
      <input class=\"btn btn-primary\" type=\"submit\" name=\"submit\" value=\"";
yield _gettext("Go");
        // line 62
        yield "\">
    </div>
  </div>
</form>
<div id=\"sqlqueryresultsouter\"></div>
";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "table/find_replace/index.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable()
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return array (  168 => 62,  160 => 57,  152 => 52,  146 => 51,  142 => 49,  140 => 48,  136 => 47,  134 => 46,  131 => 45,  128 => 44,  124 => 43,  120 => 41,  112 => 36,  104 => 31,  97 => 27,  90 => 24,  86 => 23,  82 => 22,  78 => 21,  70 => 16,  66 => 15,  58 => 10,  54 => 9,  46 => 4,  42 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "table/find_replace/index.twig", "/usr/local/cpanel/base/3rdparty/phpMyAdmin/templates/table/find_replace/index.twig");
    }
}
