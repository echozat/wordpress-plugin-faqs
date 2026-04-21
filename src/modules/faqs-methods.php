<?php

function faqs_getAll($id, $Args = array('accordion' => false, 'tabs' => false))
{
	$Faqs = faqs\FAQsData::getAllFaqs($id, $Args);

   foreach ($Faqs as $key => $faqs) 
   {
      unset($faqs->faq_id);
      unset($faqs->category_id);
      unset($faqs->question_order);
      unset($faqs->created_at);
      unset($faqs->updated_at);
      unset($faqs->icon);
      unset($faqs->misc);
      unset($faqs->status);
   }

   // if((isset($Args['accordion']) && $Args['accordion'] == true) && 
   //    (isset($Args['tabs']) && $Args['tabs'] == true))
   // {
   //    faqsGetQuestionsTabsAccordian($Faqs);
   //    return;
   // }
   if((isset($Args['accordion']) && $Args['accordion'] == true))
   {      
      faqsGetQuestionsAccordian($Faqs);
      return;
   }

   return $Faqs; 	
}

function faqsGetQuestionsAccordian($Faqs)
{
   ?>   
   <div class="faqs-accordian-sec">
      <?php 
      foreach($Faqs as $Ques)
      {
         ?>
         <div class="faqs-accordian-section">
            <div class="faqs-header">
               <h4>
                  <i class="faq-arrow-right faq-arrow"></i>
                  <?php echo $Ques->question; ?>
               </h4>
            </div>

            <div class="faqs-content">
               <?php echo $Ques->answer; ?>
            </div>
         </div>  
         <?php
      }
      ?>   
   </div>   
   <?php
}

function faqsGetQuestionsTabsAccordian($Faqs)
{
   ?>   
   <div class="faqs-tabsaccordian-sec">
      <ul class="faqs-tabs">
         <?php
         $FirstCat = true; 
         $FaqsCats = faqs\faqsRemoveRepeatedDataFromArray($Faqs);
         
         ?>
      </ul> 

      <div class="faqs-contentaccordian-sec">
         <?php 
         foreach($Faqs as $Ques)
         {
            ?>
            <div class="faqs-accordian-section">
               <div class="faqs-header">
                  <h4>
                     <i class="faq-arrow-right faq-arrow"></i>
                     <?php echo $Ques->question; ?>
                  </h4>
               </div>

               <div class="faqs-content">
                  <?php echo $Ques->answer; ?>
               </div>
            </div>  
            <?php
         }
         ?>   
      </div>

   </div>   
   <?php
}

?>