<form id="campaign_parent" name="Options" method="post" action="/localpum/index.php?q=civicrm/admin/options/campaign_type">
    <div>
        <input type="hidden" value="e9223f45bf8d5e2ff875403886a37687_267" name="qfKey">
        <input type="hidden" value="http://localhost/localpum/index.php?q=civicrm/admin/options/campaign_type&amp;group=campaign_type&amp;action=update&amp;id=355&amp;reset=1" name="entryURL">
        <input type="hidden" value="Options:next" name="_qf_default">
    </div>
    <h3>Edit Campaign Type Option</h3>
    <div class="crm-block crm-form-block crm-admin-options-form-block">
        <div class="crm-submit-buttons">
            <span class="crm-button crm-button-type-next crm-button_qf_Options_next">
                <input id="_qf_Options_next-top" class="validate form-submit default" type="submit" value="Save" name="_qf_Options_next" accesskey="S">
            </span>
            <span class="crm-button crm-button-type-cancel crm-button_qf_Options_cancel">
                <input id="_qf_Options_cancel-top" class="cancel form-submit" type="submit" value="Cancel" name="_qf_Options_cancel">
            </span>
        </div>    
        <table class="form-layout-compressed">
            {if $gName eq 'custom_search'}
               <tr class="crm-admin-options-form-block-custom_search_path">
                 <td class="label">{ts}Custom Search Path{/ts}</td>
                 <td>{$form.label.html}<br />
                    <span class="description">{ts}Enter the "class path" for this custom search here.{/ts}
                 </td>
               </tr>
            {elseif $gName eq 'from_email_address'}
               <tr class="crm-admin-options-form-block-from_email_address">
                 <td class="label">{ts}FROM Email Address{/ts} {if $action == 2}{include file='CRM/Core/I18n/Dialog.tpl' table='civicrm_option_value' field='label' id=$id}{/if}</td>
                 <td>{$form.label.html}<br />
                    <span class="description">{ts}Include double-quotes (&quot;) around the name and angle-brackets (&lt; &gt;) around the email address.<br />EXAMPLE: <em>&quot;Client Services&quot; &lt;clientservices@example.org&gt;</em>{/ts}<span>
                 </td>
               </tr>
            {elseif $gName eq 'redaction_rule'}
               <tr class="crm-admin-options-form-block-expression">
                 <td class="label">{ts}Match Value or Expression{/ts} {if $action == 2}{include file='CRM/Core/I18n/Dialog.tpl' table='civicrm_option_value' field='label' id=$id}{/if}</td>
                 <td>{$form.label.html}<br />
                    <span class="description">{ts}A "string value" or regular expression to be redacted (replaced).{/ts}</span>
                 </td>
               </tr>
            {else}
               <tr class="crm-admin-options-form-block-label">
                 <td class="label">{$form.label.label} {if $action == 2}{include file='CRM/Core/I18n/Dialog.tpl' table='civicrm_option_value' field='label' id=$id}{/if}</td>
                 <td class="html-adjust">{$form.label.html}<br />
                   <span class="description">{ts}The option label is displayed to users.{/ts}</span>
                 </td>
               </tr>
         {if $form.financial_account_id.html}
                 <tr class="crm-admin-options-form-block-grouping">
                   <td class="label">{$form.financial_account_id.label}</td>
                   <td>{$form.financial_account_id.html}</td>
                 </tr>
         {/if}
            {/if}
          {if $gName eq 'case_status'}
                <tr class="crm-admin-options-form-block-grouping">
                  <td class="label">{$form.grouping.label}</td>
                    <td>{$form.grouping.html}</td>
                </tr>
          {/if}
            {if $gName eq 'custom_search'}
               <tr class="crm-admin-options-form-block-search_title">
                 <td class="label">{ts}Search Title{/ts}</td>
                 <td>{$form.description.html}<br />
                   <span class="description">{ts}This title is displayed to users in the Custom Search listings.{/ts}</span>
                 </td>
               </tr>
            {else}
               {if $gName eq 'redaction_rule'}
                  <tr class="crm-admin-options-form-block-replacement">
                     <td class="label">{ts}Replacement (prefix){/ts}</td>
                     <td>{$form.value.html}<br />
                       <span class="description">{ts}Matched values are replaced with this prefix plus a unique code. EX: If replacement prefix for &quot;Vancouver&quot; is <em>city_</em>, occurrences will be replaced with <em>city_39121</em>.{/ts}</span>
                     </td>
                  </tr>
                {elseif $form.value.html}
                  <tr class="crm-admin-options-form-block-value">
                    <td class="label">{$form.value.label}</td>
                    <td>{$form.value.html}<br />
                        <span class="description">{ts}The option value is stored in your database.{/ts}</span>
                    </td>
                  </tr>
                {/if}
                {if $form.name.html} {* Get the name value also *}
                  <tr class="crm-admin-options-form-block-name">
                    <td class="label">{$form.name.label}</td>
                    <td>{$form.name.html}<br />
                       <span class="description">{ts}The class name which implements this functionality.{/ts}</span>
                    </td>
                  </tr>
                {/if}
                {if $form.filter.html} {* Filter property is only exposed for some option groups. *}
                  <tr class="crm-admin-options-form-block-filter">
                    <td class="label">{$form.filter.label}</td>
                    <td>{$form.filter.html}</td>
                  </tr>
                {/if}
                  <tr class="crm-admin-options-form-block-desciption">
                    <td class="label">{$form.description.label}</td>
                    <td>{$form.description.html}<br />
                {if $gName eq 'activity_type'}
                   <span class="description">{ts}Description is included at the top of the activity edit and view pages for this type of activity.{/ts}</span>
                    </td>
                  </tr>
                {/if}
            {/if}
            {if $gName eq 'participant_status'}
                  <tr class="crm-admin-options-form-block-visibility_id">
                    <td class="label">{$form.visibility_id.label}</td>
                    <td>{$form.visibility_id.html}</td>
                  </tr>
            {/if}
                  <tr class="crm-admin-options-form-block-weight">
                    <td class="label">{$form.weight.label}</td>
                    <td>{$form.weight.html}</td>
                  </tr>
            {if $form.component_id.html} {* Component ID is exposed for activity types if CiviCase is enabled. *}
                  <tr class="crm-admin-options-form-block-component_id">
                    <td class="label">{$form.component_id.label}</td>
                    <td>{$form.component_id.html}</td>
                  </tr>
            {/if}
                  <tr class="crm-admin-options-form-block-is_active">
                    <td class="label">{$form.is_active.label}</td>
                    <td>{$form.is_active.html}</td>
                  </tr>
            {if $showDefault}
                  <tr class="crm-admin-options-form-block-is_default">
                    <td class="label">{$form.is_default.label}</td>
                    <td>{$form.is_default.html}</td>
                  </tr>
            {/if}
            {if $showContactFilter}{* contactOptions is exposed for email/postal greeting and addressee types to set filter for contact types *}
               <tr class="crm-admin-options-form-block-contactOptions">
                 <td class="label">{$form.contactOptions.label}</td>
                 <td>{$form.contactOptions.html}</td>
               </tr>
            {/if}
            {if $gName == "campaign_type"}
                <tr>
                    <td class="label"><label for="parent_type">Parent Type</label></td>
                    <td id="parent_type">{$form.parent_types}</td>
                </tr>
            {/if}
        </table>
        <div class="crm-submit-buttons">
            <span class="crm-button crm-button-type-next crm-button_qf_Options_next">
                <input id="_qf_Options_next-bottom" class="validate form-submit default" type="submit" value="Save" name="_qf_Options_next" accesskey="S">
            </span>
            <span class="crm-button crm-button-type-cancel crm-button_qf_Options_cancel">
                <input id="_qf_Options_cancel-bottom" class="cancel form-submit" type="submit" value="Cancel" name="_qf_Options_cancel">
            </span>
        </div>
    </div>
</form>
{literal}
    <script type="text/javascript">
        cj('#Options').replaceWith('#campaign_parent');
    </script>
{/literal}