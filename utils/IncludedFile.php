<?php
// include database,helper, and object files
include_once '../../config/DbConnection.php';
include_once '../../model/Medicine.php';
include_once '../../model/Disease.php';
include_once '../../model/DiseaseSolution.php';
include_once '../../model/DiseaseSymptomp.php';
include_once '../../model/DiseaseMedicine.php';
include_once '../../model/Solution.php';
include_once '../../model/Symptomp.php';
include_once '../../model/SymptompCategory.php';
include_once '../../model/SymptompConsultation.php';
include_once '../../model/Consultation.php';
include_once '../../model/ConsultationResult.php';
include_once '../../helper/IndonesianDate.php';
include_once '../../helper/RemoveHtmlTags.php';
include_once '../../helper/HttpResponseMessage.php';
include_once  '../../helper/ExecuteQuery.php';