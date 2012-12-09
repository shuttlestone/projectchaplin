<?php
class default_Form_Video_Upload extends Zend_Form
{
    public function init()
    {
        $this->setAction('');
        $this->setMethod('post');
        $this->setEncType('multipart/form-data');
        
        $upload = new Zend_Form_Element_File(
            'Files[]',
            array(
                'label' => 'Upload files...',
                'multiple' => 'multiple',
                'isArray' => true
            )
        );
        $upload->addValidators(array(
            new Zend_Validate_File_Size(array(
                'max' => 200*1024*1024
            ))
        ));            
        $strLocation = realpath(APPLICATION_PATH.'/../public/uploads');
        $upload->setDestination($strLocation);
        
        $progress = new Zend_Form_Element_Hidden(
            ini_get('session.upload_progress.name')
        );
        $progress->setValue('file');
        
        $submit = new Zend_Form_Element_Submit('Upload');
        $submit->setLabel('Upload');
        
        $this->addElements(array($progress, $upload, $submit));
    }
}
        
        