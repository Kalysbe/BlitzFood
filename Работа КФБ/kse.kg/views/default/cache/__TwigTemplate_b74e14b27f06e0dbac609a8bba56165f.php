<?php

/* topmenu.html */
class __TwigTemplate_b74e14b27f06e0dbac609a8bba56165f extends Twig_Template
{
    public function display(array $context)
    {
        // line 1
        echo "<script type=\"text/javascript\" src=\"";
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/scripts/superfish/js/superfish.js\"></script>
<script type=\"text/javascript\">
    \$(document).ready(function() {
        \$('sssssul.sfss-menu').superfish();
    });
</script>
                <ul class=\"sf-menu\">
\t\t\t<li><a href=\"";
        // line 8
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/GeneralInfo\" class=\"top_element\">";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{temp_about}", array(), "array");
        echo "<!--О бирже--></a>
                            <ul>
                                <li><a href=\"";
        // line 10
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/GeneralInfo\">";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{temp_general_info}", array(), "array");
        echo "</a></li>
\t\t\t\t\t\t\t\t<li><a href=\"";
        // line 11
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/Auctioneers\">";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{temp_auctioneers}", array(), "array");
        echo "</a></li>
\t\t\t\t\t\t\t\t<li><a href=\"";
        // line 12
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/Management\">";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{temp_management}", array(), "array");
        echo "</a></li>
\t\t\t\t\t\t\t\t<li><a href=\"";
        // line 13
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/Revisory\">";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{temp_revisory}", array(), "array");
        echo "</a></li>
\t\t\t\t\t\t\t\t\t<li><a href=\"";
        // line 14
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/CommitteeListing\">";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{temp_Committees}", array(), "array");
        echo "</a>
\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t     <ul>
                                        <li><a href=\"";
        // line 17
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/CommitteeListing\">";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{temp_ListingCommittee}", array(), "array");
        echo "</a></li>
                                        <li><a href=\"";
        // line 18
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/CommitteeStrategicPlanning\">";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{temp_StrategicPlanningCommittee}", array(), "array");
        echo "</a></li>
\t\t\t\t\t\t\t\t\t\t<li><a href=\"";
        // line 19
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/CommitteeAudit\">";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{temp_AuditCommittee}", array(), "array");
        echo "</a></li>
                                    </ul>
                                </li>
\t\t\t\t\t\t\t\t<li><a href=\"";
        // line 22
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/Members\">";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{temp_members}", array(), "array");
        echo "</a>
\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t     <ul>
                                        <li><a href=\"";
        // line 25
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/Members\">";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{temp_members}", array(), "array");
        echo "</a></li>
                                        <li><a href=\"";
        // line 26
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/MembersRating\">";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{temp_members_rating}", array(), "array");
        echo "</a></li>
                                    </ul>
                                </li>
\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t<li><a href=\"";
        // line 30
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/Partners\">";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{temp_partners}", array(), "array");
        echo "</a></li>
                                <li><a href=\"";
        // line 31
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/OurStrategy\">";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{temp_our_strategy}", array(), "array");
        echo "</a></li>
                                <li><a href=\"";
        // line 32
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/CorporateDocuments\">";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{temp_corporate_documents}", array(), "array");
        echo "</a></li>
                                  
                                </li>
                                
                            </ul>

                        </li>
\t\t\t<li><a href=\"";
        // line 39
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/Standards\" class=\"top_element\">";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{temp_standards}", array(), "array");
        echo "</a>
                            <ul>
                                <li><a href=\"";
        // line 41
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/KSENormatives\">";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{temp_kse_normatives}", array(), "array");
        echo "</a>
                                    <!--<ul id=\"jsddm_sub\">
                                        <li><a href=\"#\">test</a></li>
                                    </ul>-->
                                </li>
                                <li><a href=\"";
        // line 46
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/DepoNormatives\">";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{temp_depo_normatives}", array(), "array");
        echo "</a></li>
                                <li><a href=\"";
        // line 47
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/OpenInformation\">";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{temp_open_information}", array(), "array");
        echo "</a></li>
                            </ul>
                        </li>
\t\t\t<li><a href=\"";
        // line 50
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/Statistics\" class=\"top_element\">";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{temp_statistics}", array(), "array");
        echo "</a>
                            <ul>
                                <li><a href=\"";
        // line 52
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/TradeResults\">";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{temp_trade_results}", array(), "array");
        echo "</a></li>
                                <li><a href=\"";
        // line 53
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/TradeArchive\">";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{temp_archive}", array(), "array");
        echo "</a></li>
                                <li><a href=\"";
        // line 54
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/IndexAndCapitalization\">";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{temp_index_and_capitalization}", array(), "array");
        echo "</a></li>
                                <li><a href=\"";
        // line 55
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/Quotes\">";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{temp_quotes}", array(), "array");
        echo "</a></li>
                                <li><a href=\"";
        // line 56
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/QuotesGold\">";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{temp_quotesgold}", array(), "array");
        echo "</a></li>
\t\t\t\t\t\t\t\t<li><a href=\"";
        // line 57
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/ScheduleGS\">";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{temp_ScheduleGS}", array(), "array");
        echo "</a></li>
                            </ul>
                        </li>

\t\t\t<li><a href=\"";
        // line 61
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/Education\" class=\"top_element\">";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{temp_study_center}", array(), "array");
        echo "</a>
                            <ul>
                                <li><a href=\"";
        // line 63
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/Education\">";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{temp_education}", array(), "array");
        echo "</a></li>
                                <li><a href=\"";
        // line 64
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/EduPlan\">";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{temp_edu_plan}", array(), "array");
        echo "</a></li>
                            </ul>
                        </li>
\t\t</ul>
";
    }

}
