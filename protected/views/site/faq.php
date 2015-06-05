<div class="main">
    <div class="f-l page-title">FAQ
        <div class="page-sub-title">You can find all answers here</div>
    </div>
    <div class="f-r blue-message-margin-b">
        <div class="blue-message">
            <div class="big">New Item</div>
            <div class="little">Available on market</div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="pad-mar-zero margin-top">
                <div class="faq-left-block-width f-l">
                <div class="faq-h-page-block ">
                    <div class="questions-wall-title mar-zero">
                        <div class="padding-zero">Frequently Asked questions</div>
                        <div class="clear"></div>
                    </div>
                    <div class="nano" id="questions-answers" style="height:272px;">
                        <ul class="nano-content questions-answers">
                            <li>
                                <div class="question">dsfgdfdsfsdfsdfsdfsdf</div>
                                <div class="answer">sdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsd sdf sdf sdf sdf sdfsd sdfdsd  sd fsdf sdf sdf sdfsdsds fsdf sdf sdfsdf sdf sdfsd  sddf sdf sdf
                                    sdfsd fsdf
                                    sdf
                                    sdf
                                    sdf
                                    sdf
                                    sdf
                                    sd
                                    f sd
                                    sd
                                    f ddf fsdf d
                                </div>
                            </li>
                            <li>
                                <div class="question">dsfgdfdsfsdfsdfsdfsdf</div>
                                <div class="answer">sdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsd sdf sdf sdf sdf sdfsd sdfdsd  sd fsdf sdf sdf sdfsdsds fsdf sdf sdfsdf sdf sdfsd  sddf sdf sdf
                                    sdfsd fsdf
                                    sdf
                                    sdf
                                    sdf
                                    sdf
                                    sdf
                                    sd
                                    f sd
                                    sd
                                    f ddf fsdf d
                                </div>
                            </li>
                            <li>
                                <div class="question">dsfgdfdsfsdfsdfsdfsdf</div>
                                <div class="answer">sdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsd sdf sdf sdf sdf sdfsd sdfdsd  sd fsdf sdf sdf sdfsdsds fsdf sdf sdfsdf sdf sdfsd  sddf sdf sdf
                                    sdfsd fsdf
                                    sdf
                                    sdf
                                    sdf
                                    sdf
                                    sdf
                                    sd
                                    f sd
                                    sd
                                    f ddf fsdf d
                                </div>
                            </li>
                            <li>
                                <div class="question">dsfgdfdsfsdfsdfsdfsdf</div>
                                <div class="answer">sdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsd sdf sdf sdf sdf sdfsd sdfdsd  sd fsdf sdf sdf sdfsdsds fsdf sdf sdfsdf sdf sdfsd  sddf sdf sdf
                                    sdfsd fsdf
                                    sdf
                                    sdf
                                    sdf
                                    sdf
                                    sdf
                                    sd
                                    f sd
                                    sd
                                    f ddf fsdf d
                                </div>
                            </li>
                            <li>
                                <div class="question">dsfgdfdsfsdfsdfsdfsdf</div>
                                <div class="answer">sdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsd sdf sdf sdf sdf sdfsd sdfdsd  sd fsdf sdf sdf sdfsdsds fsdf sdf sdfsdf sdf sdfsd  sddf sdf sdf
                                    sdfsd fsdf
                                    sdf
                                    sdf
                                    sdf
                                    sdf
                                    sdf
                                    sd
                                    f sd
                                    sd
                                    f ddf fsdf d
                                </div>
                            </li>
                            <li>
                                <div class="question">dsfgdfdsfsdfsdfsdfsdf</div>
                                <div class="answer">sdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsd sdf sdf sdf sdf sdfsd sdfdsd  sd fsdf sdf sdf sdfsdsds fsdf sdf sdfsdf sdf sdfsd  sddf sdf sdf
                                    sdfsd fsdf
                                    sdf
                                    sdf
                                    sdf
                                    sdf
                                    sdf
                                    sd
                                    f sd
                                    sd
                                    f ddf fsdf d
                                </div>
                            </li>
                        </ul>
                    </div>
                    <script>
                        $(document).ready(function()
                        {
                            $("#questions-answers").nanoScroller();
                            $(document).on('click','#questions-answers .question',function()
                            {
                                var th=$(this);
                                $("#questions-answers li .answer").each(function()
                                {
                                    if($(this).is(':visible')) $(this).slideUp();
                                })
                                if(th.next().is(':visible'))
                                {
                                    th.next().slideUp(function()
                                    {
                                        $("#questions-answers").nanoScroller();
                                    });
                                }
                                else
                                {
                                    th.next().slideDown(function()
                                    {
                                        $("#questions-answers").nanoScroller();
                                    });
                                }

                            })
                        })
                    </script>
                </div>
                </div>
                <div class="projects-and-wall-mar f-l faq-just-h-page-block"></div>
                <div class="faq-right-block-width f-l">
                <div class="faq-h-page-block">
                    <div class="questions-wall-title">have a question?</div>
                   <div class="quest-form-par">
                       <?php
                       $form = $this->beginWidget('CActiveForm', array(
                           'id'=>'question-form',
                           'enableAjaxValidation'=>true,
                           'enableClientValidation'=>true,
                           'htmlOptions' => array("class"=>"question-form")
                       ));
                       ?>
                       <?php $question=new Questions();?>
                       <?php echo $form->textArea($question,'question')?>
                       <div class="f-r">
                            <?php echo CHtml::submitButton('Send',array('class'=>'send-button','placeholder'=>'Enter your question...'));?>
                       </div>
                       <div class="clear"></div>
                       <?php $this->endWidget(); ?>
                       <script>
                           $(document).ready(function()
                           {
                               $(document).on('submit','#question-form',function()
                               {
                                   var th= $(this);
                                   if(!th.hasClass('disabled'))
                                   {
                                       th.addClass('disabled')
                                       var fd = th.serializeArray();
                                       $.ajax({
                                           url: "questions/create",
                                           type: "POST",
                                           data: fd,
                                           dataType: "json",
                                           success: function (data, textStatus) {
                                               th.removeClass('disabled')
                                               console.log(data)
                                               if(data.error)
                                               {
                                                   console.log(data.message)
                                               }
                                               else
                                               {
                                                   th.find("textarea").val("");
                                               }
                                           }
                                       })
                                   }

                                   return false
                               })
                           })
                       </script>
                   </div>
                </div>
        </div>

</div>
    <!-- bottom columns -->
    <div class="clear"></div>
    <div class="pad-mar-zero margin-top">
        <div class="faq-left-block-width f-l">
            <div class="faq-h-page-block ">
                <div class="questions-wall-title mar-zero">
                    <div class="padding-zero question-knowledge">Knowledge Base: <a href="#basics" class="knowledge-b current">Basics</a> | <a href="#levels" class="knowledge-l">Levels</a> | <a href="#badges" class="knowledge-bad">Badges</a></div>
                    <div class="clear"></div>
                </div>
                <div class="nano" id="questions-knowledge" style="height:272px;">
                <div class="nano-content">
                    <script>
                        $(document).ready(function()
                        {
                            $("#questions-knowledge").nanoScroller();
                            $(document).on('click','.questions-knowledge-basic .question',function()
                            {
                                var th=$(this);
                                $(".questions-knowledge-basic li .answer").each(function()
                                {
                                    if($(this).is(':visible')) $(this).slideUp();
                                })
                                if(th.next().is(':visible'))
                                {
                                    th.next().slideUp(function()
                                    {
                                        $("#questions-knowledge").nanoScroller();
                                    });
                                }
                                else
                                {
                                    th.next().slideDown(function()
                                    {
                                        $("#questions-knowledge").nanoScroller();
                                    });
                                }

                            }).on('click','.question-knowledge a',function()
                            {
                                var th=$(this);
                                if(!th.hasClass('current'))
                                {
                                    $('.question-knowledge a').removeClass('current');
                                    $('#questions-knowledge ul').hide()
                                    th.addClass('current');
                                    if(th.hasClass('knowledge-b'))
                                    {
                                        $('.questions-knowledge-basic').show()
                                    }
                                    else
                                    if(th.hasClass('knowledge-l'))
                                    {
                                        $('.questions-knowledge-levels').show();
                                    }
                                    else
                                    if(th.hasClass('knowledge-bad'))
                                    {
                                        $('.questions-knowledge-badges').show();
                                    }
                                    $("#questions-knowledge").nanoScroller();
                                }
                            })
                        })
                    </script>
                    <ul class="questions-knowledge-basic">
                        <li>
                            <div class="question">dsfgdfdsfsdfsdfsdfsdf</div>
                            <div class="answer">sdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsd sdf sdf sdf sdf sdfsd sdfdsd  sd fsdf sdf sdf sdfsdsds fsdf sdf sdfsdf sdf sdfsd  sddf sdf sdf
                                sdfsd fsdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sd
                                f sd
                                sd
                                f ddf fsdf d
                            </div>
                        </li>
                        <li>
                            <div class="question">dsfgdfdsfsdfsdfsdfsdf</div>
                            <div class="answer">sdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsd sdf sdf sdf sdf sdfsd sdfdsd  sd fsdf sdf sdf sdfsdsds fsdf sdf sdfsdf sdf sdfsd  sddf sdf sdf
                                sdfsd fsdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sd
                                f sd
                                sd
                                f ddf fsdf d
                            </div>
                        </li>
                        <li>
                            <div class="question">dsfgdfdsfsdfsdfsdfsdf</div>
                            <div class="answer">sdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsd sdf sdf sdf sdf sdfsd sdfdsd  sd fsdf sdf sdf sdfsdsds fsdf sdf sdfsdf sdf sdfsd  sddf sdf sdf
                                sdfsd fsdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sd
                                f sd
                                sd
                                f ddf fsdf d
                            </div>
                        </li>
                        <li>
                            <div class="question">dsfgdfdsfsdfsdfsdfsdf</div>
                            <div class="answer">sdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsd sdf sdf sdf sdf sdfsd sdfdsd  sd fsdf sdf sdf sdfsdsds fsdf sdf sdfsdf sdf sdfsd  sddf sdf sdf
                                sdfsd fsdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sd
                                f sd
                                sd
                                f ddf fsdf d
                            </div>
                        </li>
                        <li>
                            <div class="question">dsfgdfdsfsdfsdfsdfsdf</div>
                            <div class="answer">sdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsd sdf sdf sdf sdf sdfsd sdfdsd  sd fsdf sdf sdf sdfsdsds fsdf sdf sdfsdf sdf sdfsd  sddf sdf sdf
                                sdfsd fsdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sd
                                f sd
                                sd
                                f ddf fsdf d
                            </div>
                        </li>
                        <li>
                            <div class="question">dsfgdfdsfsdfsdfsdfsdf</div>
                            <div class="answer">sdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsd sdf sdf sdf sdf sdfsd sdfdsd  sd fsdf sdf sdf sdfsdsds fsdf sdf sdfsdf sdf sdfsd  sddf sdf sdf
                                sdfsd fsdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sd
                                f sd
                                sd
                                f ddf fsdf d
                            </div>
                        </li>
                    </ul>

                    <ul class="questions-knowledge-levels">
                        <li>
                            <div class="question">dsfgdfdsfsdfsdfsdfsdf</div>
                            <div class="answer">sdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsd sdf sdf sdf sdf sdfsd sdfdsd  sd fsdf sdf sdf sdfsdsds fsdf sdf sdfsdf sdf sdfsd  sddf sdf sdf
                                sdfsd fsdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sd
                                f sd
                                sd
                                f ddf fsdf d
                            </div>
                        </li>
                        <li>
                            <div class="question">dsfgdfdsfsdfsdfsdfsdf</div>
                            <div class="answer">sdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsd sdf sdf sdf sdf sdfsd sdfdsd  sd fsdf sdf sdf sdfsdsds fsdf sdf sdfsdf sdf sdfsd  sddf sdf sdf
                                sdfsd fsdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sd
                                f sd
                                sd
                                f ddf fsdf d
                            </div>
                        </li>
                        <li>
                            <div class="question">dsfgdfdsfsdfsdfsdfsdf</div>
                            <div class="answer">sdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsd sdf sdf sdf sdf sdfsd sdfdsd  sd fsdf sdf sdf sdfsdsds fsdf sdf sdfsdf sdf sdfsd  sddf sdf sdf
                                sdfsd fsdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sd
                                f sd
                                sd
                                f ddf fsdf d
                            </div>
                        </li>
                        <li>
                            <div class="question">dsfgdfdsfsdfsdfsdfsdf</div>
                            <div class="answer">sdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsd sdf sdf sdf sdf sdfsd sdfdsd  sd fsdf sdf sdf sdfsdsds fsdf sdf sdfsdf sdf sdfsd  sddf sdf sdf
                                sdfsd fsdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sd
                                f sd
                                sd
                                f ddf fsdf d
                            </div>
                        </li>
                        <li>
                            <div class="question">dsfgdfdsfsdfsdfsdfsdf</div>
                            <div class="answer">sdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsd sdf sdf sdf sdf sdfsd sdfdsd  sd fsdf sdf sdf sdfsdsds fsdf sdf sdfsdf sdf sdfsd  sddf sdf sdf
                                sdfsd fsdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sd
                                f sd
                                sd
                                f ddf fsdf d
                            </div>
                        </li>
                        <li>
                            <div class="question">dsfgdfdsfsdfsdfsdfsdf</div>
                            <div class="answer">sdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsd sdf sdf sdf sdf sdfsd sdfdsd  sd fsdf sdf sdf sdfsdsds fsdf sdf sdfsdf sdf sdfsd  sddf sdf sdf
                                sdfsd fsdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sd
                                f sd
                                sd
                                f ddf fsdf d
                            </div>
                        </li>
                    </ul>

                    <!--badges -->
                    <ul class="questions-knowledge-badges">
                        <li>
                            <div class="question">dsfgdfdsfsdfsdfsdfsdf</div>
                            <div class="answer">sdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsd sdf sdf sdf sdf sdfsd sdfdsd  sd fsdf sdf sdf sdfsdsds fsdf sdf sdfsdf sdf sdfsd  sddf sdf sdf
                                sdfsd fsdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sd
                                f sd
                                sd
                                f ddf fsdf d
                            </div>
                        </li>
                        <li>
                            <div class="question">dsfgdfdsfsdfsdfsdfsdf</div>
                            <div class="answer">sdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsd sdf sdf sdf sdf sdfsd sdfdsd  sd fsdf sdf sdf sdfsdsds fsdf sdf sdfsdf sdf sdfsd  sddf sdf sdf
                                sdfsd fsdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sd
                                f sd
                                sd
                                f ddf fsdf d
                            </div>
                        </li>
                        <li>
                            <div class="question">dsfgdfdsfsdfsdfsdfsdf</div>
                            <div class="answer">sdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsd sdf sdf sdf sdf sdfsd sdfdsd  sd fsdf sdf sdf sdfsdsds fsdf sdf sdfsdf sdf sdfsd  sddf sdf sdf
                                sdfsd fsdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sd
                                f sd
                                sd
                                f ddf fsdf d
                            </div>
                        </li>
                        <li>
                            <div class="question">dsfgdfdsfsdfsdfsdfsdf</div>
                            <div class="answer">sdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsd sdf sdf sdf sdf sdfsd sdfdsd  sd fsdf sdf sdf sdfsdsds fsdf sdf sdfsdf sdf sdfsd  sddf sdf sdf
                                sdfsd fsdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sd
                                f sd
                                sd
                                f ddf fsdf d
                            </div>
                        </li>
                        <li>
                            <div class="question">dsfgdfdsfsdfsdfsdfsdf</div>
                            <div class="answer">sdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsd sdf sdf sdf sdf sdfsd sdfdsd  sd fsdf sdf sdf sdfsdsds fsdf sdf sdfsdf sdf sdfsd  sddf sdf sdf
                                sdfsd fsdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sd
                                f sd
                                sd
                                f ddf fsdf d
                            </div>
                        </li>
                        <li>
                            <div class="question">dsfgdfdsfsdfsdfsdfsdf</div>
                            <div class="answer">sdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsd sdf sdf sdf sdf sdfsd sdfdsd  sd fsdf sdf sdf sdfsdsds fsdf sdf sdfsdf sdf sdfsd  sddf sdf sdf
                                sdfsd fsdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sdf
                                sd
                                f sd
                                sd
                                f ddf fsdf d
                            </div>
                        </li>
                    </ul>
                </div>
                </div>
            </div>
        </div>
        <div class="projects-and-wall-mar f-l"></div>
        <div class="faq-right-block-width f-l">
            <div class="faq-h-page-block">
                Formula - the salary counter

            </div>
        </div>

    </div>
