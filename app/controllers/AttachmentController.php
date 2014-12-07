<?php

    /**
     * Created by PhpStorm.
     * User: Suresh
     * Date: 07-Dec-14
     * Time: 2:15 AM
     */
    class AttachmentController extends BaseController
    {

        public function update()
        {
            return Attachment::updateAttachment();
        }
    }