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

/* table/zoom_search/index.twig */
class __TwigTemplate_a990732c140290840556bde0e030a623 extends Template
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
    <a class=\"nav-link active disableAjax\" href=\"";
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
    <a class=\"nav-link disableAjax\" href=\"";
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
        yield PhpMyAdmin\Url::getFromRoute("/table/zoom-search", ["db" => ($context["db"] ?? null), "table" => ($context["table"] ?? null)]);
        yield "\" name=\"insertForm\" id=\"zoom_search_form\" class=\"ajax lock-page\">
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
        yield PhpMyAdmin\Url::getFromRoute("/table/zoom-search", ["db" => ($context["db"] ?? null), "table" => ($context["table"] ?? null)]);
        yield "\">

  <div class=\"card mb-3\">
    <div class=\"card-header\">";
yield _gettext("Do a \"query by example\" (wildcard: \"%\") for two different columns");
        // line 27
        yield "</div>

    <div class=\"card-body\" id=\"inputSection\">
      <table class=\"table table-striped table-hover table-sm w-auto\" id=\"tableFieldsId\">
        <thead>
          <tr>
            ";
        // line 33
        if (($context["geom_column_flag"] ?? null)) {
            // line 34
            yield "              <th>";
yield _gettext("Function");
            yield "</th>
            ";
        }
        // line 36
        yield "            <th>";
yield _gettext("Column");
        yield "</th>
            <th>";
yield _gettext("Type");
        // line 37
        yield "</th>
            <th>";
yield _gettext("Collation");
        // line 38
        yield "</th>
            <th>";
yield _gettext("Operator");
        // line 39
        yield "</th>
            <th>";
yield _gettext("Value");
        // line 40
        yield "</th>
          </tr>
        </thead>
        <tbody>
          ";
        // line 44
        $context["type"] = [];
        // line 45
        yield "          ";
        $context["collation"] = [];
        // line 46
        yield "          ";
        $context["func"] = [];
        // line 47
        yield "          ";
        $context["value"] = [];
        // line 48
        yield "
          ";
        // line 49
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(range(0, 3));
        foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
            // line 50
            yield "            ";
            // line 51
            yield "            ";
            if (($context["i"] == 2)) {
                // line 52
                yield "              <tr>
                <th>
                  ";
yield _gettext("Additional search criteria");
                // line 55
                yield "                </th>
              </tr>
            ";
            }
            // line 58
            yield "            <tr class=\"noclick\">
              <th>
                <select name=\"criteriaColumnNames[]\" id=\"tableid_";
            // line 60
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["i"], "html", null, true);
            yield "\">
                  <option value=\"pma_null\">
                    ";
yield _gettext("None");
            // line 63
            yield "                  </option>
                  ";
            // line 64
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(range(0, (Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["column_names"] ?? null)) - 1)));
            foreach ($context['_seq'] as $context["_key"] => $context["j"]) {
                // line 65
                yield "                    ";
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["criteria_column_names"] ?? null), $context["i"], [], "array", true, true, false, 65) && ((($__internal_compile_0 = ($context["criteria_column_names"] ?? null)) && is_array($__internal_compile_0) || $__internal_compile_0 instanceof ArrayAccess ? ($__internal_compile_0[$context["i"]] ?? null) : null) == (($__internal_compile_1 = ($context["column_names"] ?? null)) && is_array($__internal_compile_1) || $__internal_compile_1 instanceof ArrayAccess ? ($__internal_compile_1[$context["j"]] ?? null) : null)))) {
                    // line 66
                    yield "                      <option value=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($__internal_compile_2 = ($context["column_names"] ?? null)) && is_array($__internal_compile_2) || $__internal_compile_2 instanceof ArrayAccess ? ($__internal_compile_2[$context["j"]] ?? null) : null), "html", null, true);
                    yield "\" selected>
                        ";
                    // line 67
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($__internal_compile_3 = ($context["column_names"] ?? null)) && is_array($__internal_compile_3) || $__internal_compile_3 instanceof ArrayAccess ? ($__internal_compile_3[$context["j"]] ?? null) : null), "html", null, true);
                    yield "
                      </option>
                    ";
                } else {
                    // line 70
                    yield "                      <option value=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($__internal_compile_4 = ($context["column_names"] ?? null)) && is_array($__internal_compile_4) || $__internal_compile_4 instanceof ArrayAccess ? ($__internal_compile_4[$context["j"]] ?? null) : null), "html", null, true);
                    yield "\">
                        ";
                    // line 71
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($__internal_compile_5 = ($context["column_names"] ?? null)) && is_array($__internal_compile_5) || $__internal_compile_5 instanceof ArrayAccess ? ($__internal_compile_5[$context["j"]] ?? null) : null), "html", null, true);
                    yield "
                      </option>
                    ";
                }
                // line 74
                yield "                  ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['j'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 75
            yield "                </select>
              </th>
              ";
            // line 77
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["criteria_column_names"] ?? null), $context["i"], [], "array", true, true, false, 77) && ((($__internal_compile_6 = ($context["criteria_column_names"] ?? null)) && is_array($__internal_compile_6) || $__internal_compile_6 instanceof ArrayAccess ? ($__internal_compile_6[$context["i"]] ?? null) : null) != "pma_null"))) {
                // line 78
                yield "                ";
                $context["key"] = (($__internal_compile_7 = ($context["keys"] ?? null)) && is_array($__internal_compile_7) || $__internal_compile_7 instanceof ArrayAccess ? ($__internal_compile_7[(($__internal_compile_8 = ($context["criteria_column_names"] ?? null)) && is_array($__internal_compile_8) || $__internal_compile_8 instanceof ArrayAccess ? ($__internal_compile_8[$context["i"]] ?? null) : null)] ?? null) : null);
                // line 79
                yield "                ";
                $context["properties"] = CoreExtension::getAttribute($this->env, $this->source, ($context["self"] ?? null), "getColumnProperties", [$context["i"], ($context["key"] ?? null)], "method", false, false, false, 79);
                // line 80
                yield "                ";
                $context["type"] = Twig\Extension\CoreExtension::merge(($context["type"] ?? null), [$context["i"] => (($__internal_compile_9 = ($context["properties"] ?? null)) && is_array($__internal_compile_9) || $__internal_compile_9 instanceof ArrayAccess ? ($__internal_compile_9["type"] ?? null) : null)]);
                // line 81
                yield "                ";
                $context["collation"] = Twig\Extension\CoreExtension::merge(($context["collation"] ?? null), [$context["i"] => (($__internal_compile_10 = ($context["properties"] ?? null)) && is_array($__internal_compile_10) || $__internal_compile_10 instanceof ArrayAccess ? ($__internal_compile_10["collation"] ?? null) : null)]);
                // line 82
                yield "                ";
                $context["func"] = Twig\Extension\CoreExtension::merge(($context["func"] ?? null), [$context["i"] => (($__internal_compile_11 = ($context["properties"] ?? null)) && is_array($__internal_compile_11) || $__internal_compile_11 instanceof ArrayAccess ? ($__internal_compile_11["func"] ?? null) : null)]);
                // line 83
                yield "                ";
                $context["value"] = Twig\Extension\CoreExtension::merge(($context["value"] ?? null), [$context["i"] => (($__internal_compile_12 = ($context["properties"] ?? null)) && is_array($__internal_compile_12) || $__internal_compile_12 instanceof ArrayAccess ? ($__internal_compile_12["value"] ?? null) : null)]);
                // line 84
                yield "              ";
            }
            // line 85
            yield "              ";
            // line 86
            yield "              <td dir=\"ltr\">
                ";
            // line 87
            ((CoreExtension::getAttribute($this->env, $this->source, ($context["type"] ?? null), $context["i"], [], "array", true, true, false, 87)) ? (yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($__internal_compile_13 = ($context["type"] ?? null)) && is_array($__internal_compile_13) || $__internal_compile_13 instanceof ArrayAccess ? ($__internal_compile_13[$context["i"]] ?? null) : null), "html", null, true)) : (yield ""));
            yield "
              </td>
              ";
            // line 90
            yield "              <td>
                ";
            // line 91
            ((CoreExtension::getAttribute($this->env, $this->source, ($context["collation"] ?? null), $context["i"], [], "array", true, true, false, 91)) ? (yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($__internal_compile_14 = ($context["collation"] ?? null)) && is_array($__internal_compile_14) || $__internal_compile_14 instanceof ArrayAccess ? ($__internal_compile_14[$context["i"]] ?? null) : null), "html", null, true)) : (yield ""));
            yield "
              </td>
              ";
            // line 94
            yield "              <td>
                ";
            // line 95
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["func"] ?? null), $context["i"], [], "array", true, true, false, 95)) ? ((($__internal_compile_15 = ($context["func"] ?? null)) && is_array($__internal_compile_15) || $__internal_compile_15 instanceof ArrayAccess ? ($__internal_compile_15[$context["i"]] ?? null) : null)) : (""));
            yield "
              </td>
              ";
            // line 98
            yield "              <td>
                ";
            // line 99
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["value"] ?? null), $context["i"], [], "array", true, true, false, 99)) ? ((($__internal_compile_16 = ($context["value"] ?? null)) && is_array($__internal_compile_16) || $__internal_compile_16 instanceof ArrayAccess ? ($__internal_compile_16[$context["i"]] ?? null) : null)) : (""));
            yield "
              </td>
              <td>
                ";
            // line 103
            yield "                <input type=\"hidden\" name=\"criteriaColumnTypes[";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["i"], "html", null, true);
            yield "]\" id=\"types_";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["i"], "html", null, true);
            yield "\"";
            // line 104
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["criteria_column_types"] ?? null), $context["i"], [], "array", true, true, false, 104)) {
                yield " value=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($__internal_compile_17 = ($context["criteria_column_types"] ?? null)) && is_array($__internal_compile_17) || $__internal_compile_17 instanceof ArrayAccess ? ($__internal_compile_17[$context["i"]] ?? null) : null), "html", null, true);
                yield "\"";
            }
            yield ">
                <input type=\"hidden\" name=\"criteriaColumnCollations[";
            // line 105
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["i"], "html", null, true);
            yield "]\" id=\"collations_";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["i"], "html", null, true);
            yield "\">
              </td>
            </tr>
          ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 109
        yield "        </tbody>
      </table>

      <table class=\"table table-borderless table-sm w-auto\">
        <tr>
          <td>
            <label for=\"dataLabel\">
              ";
yield _gettext("Use this column to label each point");
        // line 117
        yield "            </label>
          </td>
          <td>
            <select name=\"dataLabel\" id=\"dataLabel\">
              <option value=\"\">
                ";
yield _gettext("None");
        // line 123
        yield "              </option>
              ";
        // line 124
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(range(0, (Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["column_names"] ?? null)) - 1)));
        foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
            // line 125
            yield "                ";
            if ((array_key_exists("data_label", $context) && (($context["data_label"] ?? null) == $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($__internal_compile_18 = ($context["column_names"] ?? null)) && is_array($__internal_compile_18) || $__internal_compile_18 instanceof ArrayAccess ? ($__internal_compile_18[$context["i"]] ?? null) : null))))) {
                // line 126
                yield "                  <option value=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($__internal_compile_19 = ($context["column_names"] ?? null)) && is_array($__internal_compile_19) || $__internal_compile_19 instanceof ArrayAccess ? ($__internal_compile_19[$context["i"]] ?? null) : null), "html", null, true);
                yield "\" selected>
                    ";
                // line 127
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($__internal_compile_20 = ($context["column_names"] ?? null)) && is_array($__internal_compile_20) || $__internal_compile_20 instanceof ArrayAccess ? ($__internal_compile_20[$context["i"]] ?? null) : null), "html", null, true);
                yield "
                  </option>
                ";
            } else {
                // line 130
                yield "                  <option value=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($__internal_compile_21 = ($context["column_names"] ?? null)) && is_array($__internal_compile_21) || $__internal_compile_21 instanceof ArrayAccess ? ($__internal_compile_21[$context["i"]] ?? null) : null), "html", null, true);
                yield "\">
                    ";
                // line 131
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($__internal_compile_22 = ($context["column_names"] ?? null)) && is_array($__internal_compile_22) || $__internal_compile_22 instanceof ArrayAccess ? ($__internal_compile_22[$context["i"]] ?? null) : null), "html", null, true);
                yield "
                  </option>
                ";
            }
            // line 134
            yield "              ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 135
        yield "            </select>
          </td>
        </tr>
        <tr>
          <td>
            <label for=\"maxRowPlotLimit\">
              ";
yield _gettext("Maximum rows to plot");
        // line 142
        yield "            </label>
          </td>
          <td>
            <input type=\"number\" name=\"maxPlotLimit\" id=\"maxRowPlotLimit\" required=\"required\" value=\"";
        // line 145
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["max_plot_limit"] ?? null), "html", null, true);
        yield "\">
          </td>
        </tr>
      </table>

      <div id=\"gis_editor\"></div>
      <div id=\"popup_background\"></div>
    </div>

    <div class=\"card-footer\">
      <input class=\"btn btn-primary\" type=\"submit\" name=\"zoom_submit\" id=\"inputFormSubmitId\" value=\"";
yield _gettext("Go");
        // line 155
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
        return "table/zoom_search/index.twig";
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
        return array (  390 => 155,  376 => 145,  371 => 142,  362 => 135,  356 => 134,  350 => 131,  345 => 130,  339 => 127,  334 => 126,  331 => 125,  327 => 124,  324 => 123,  316 => 117,  306 => 109,  294 => 105,  286 => 104,  280 => 103,  274 => 99,  271 => 98,  266 => 95,  263 => 94,  258 => 91,  255 => 90,  250 => 87,  247 => 86,  245 => 85,  242 => 84,  239 => 83,  236 => 82,  233 => 81,  230 => 80,  227 => 79,  224 => 78,  222 => 77,  218 => 75,  212 => 74,  206 => 71,  201 => 70,  195 => 67,  190 => 66,  187 => 65,  183 => 64,  180 => 63,  174 => 60,  170 => 58,  165 => 55,  160 => 52,  157 => 51,  155 => 50,  151 => 49,  148 => 48,  145 => 47,  142 => 46,  139 => 45,  137 => 44,  131 => 40,  127 => 39,  123 => 38,  119 => 37,  113 => 36,  107 => 34,  105 => 33,  97 => 27,  90 => 24,  86 => 23,  82 => 22,  78 => 21,  70 => 16,  66 => 15,  58 => 10,  54 => 9,  46 => 4,  42 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "table/zoom_search/index.twig", "/usr/local/cpanel/base/3rdparty/phpMyAdmin/templates/table/zoom_search/index.twig");
    }
}
