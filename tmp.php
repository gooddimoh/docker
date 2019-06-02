<?php
public
function newQuestion()
{
    if (!empty(User::getUid())) {
        foreach ($_POST as $k => $v) {
            $_POST[$k] = trim($_POST[$k]);
        }

        if (!empty($_POST['questionName']) && mb_strlen($_POST['questionName'], 'utf-8') > 1 && mb_strlen($_POST['questionName'], 'utf-8') < 151) {
            $this->model_newQuestion_params[] = '":name"';
            $this->model_newQuestion_data[':name'] = $_POST['questionName'];
        }

        if (!empty($_POST['questionHiddenCategories']) && mb_strlen($_POST['questionHiddenCategories'], 'utf-8') > 2 && mb_strlen($_POST['questionHiddenCategories'], 'utf-8') < 251) {
            $this->model_newQuestion_params[] = '":category"';
            $this->model_newQuestion_data[':category'] = $_POST['questionHiddenCategories'];
        }

        if (!empty($_POST['questionDescription']) && mb_strlen($_POST['questionDescription'], 'utf-8') > 9 && mb_strlen($_POST['questionDescription'], 'utf-8') < 4001) {
            $this->model_newQuestion_params[] = '":description"';
            $this->model_newQuestion_data[':description'] = $_POST['questionDescription'];
        }

        if (!empty($_POST['questionDeadline']) && preg_match('/\d{4}-\d{2}-\d{2}/', $_POST['questionDeadline']) && !empty($_POST['questionTimepicker']) && preg_match('/\d{2}:\d{2}/', $_POST['questionTimepicker'])) {
            $this->model_newQuestion_params[] = '":deadline"';
            $this->model_newQuestion_data[':deadline'] = $_POST['questionDeadline'] . ' ' . $_POST['questionTimepicker'] . ':00';
        }


        if (count($this->model_newQuestion_params) > 0 && count($this->model_newQuestion_data) > 0) {
            $this->model_newQuestion_params[] = '":uid"';
            $this->model_newQuestion_data[':uid'] = User::getUid();
            $this->model_newQuestion_params[] = '":status"';
            $this->model_newQuestion_data[':status'] = self::STATUS_QUESTION_ACTIVE;

            $params = implode(", ", $this->model_newQuestion_params);
            $this->model = new Model();
            $this->model->createNewQuestion($params, $this->model_newQuestion_data);
        } else {
            return ['messageType' => 'error', 'message' => self::t('DataNotValidated')];
        }
        return ['messageType' => 'success', 'message' => self::t('DataSaved')];
    }
    return ['messageType' => 'error', 'message' => self::t('YouNotAutore')];
}