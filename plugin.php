<?php

// Copyright 2013 Shaun Merchant

if (!defined("IN_ESOTALK")) exit;

ET::$pluginInfo["Statuses"] = array(
	"name" => "Conversation Statuses",
	"description" => "Allow those who can moderate to set a status to conversations.",
	"version" => "0.6",
	"author" => "Shaun Merchant",
	"authorEmail" => "shaun@gravitygrip.co.uk",
	"authorURL" => "http://www.gravitygrip.co.uk/",
	"license" => "GPLv2"
);

class ETPlugin_Statuses extends ETPlugin 
{	
	public function setup($oldVersion = "") 
    {
		$structure = ET::$database->structure();
		$structure->table("conversation")
			->column("status", "int(11) unsigned")
			->exec(false);
		return true;
	}
	public function init() 
    {
		ET::conversationModel();
		ETConversationModel::addLabel("none", "IF(c.status = NULL,1,0)", "");
		ETConversationModel::addLabel("done", "IF(c.status = 1,1,0)", "icon-check");
		ETConversationModel::addLabel("inprogress", "IF(c.status = 2,1,0)", "icon-cogs");
		ETConversationModel::addLabel("rejected", "IF(c.status = 3,1,0)", "icon-thumbs-down");
		ETConversationModel::addLabel("highpriority", "IF(c.status = 4,1,0)", "icon-circle");
		ETConversationModel::addLabel("lowpriority", "IF(c.status = 5,1,0)", "icon-circle-blank");

		ET::define("label.none", "");
		ET::define("label.done", "Done");
		ET::define("label.inprogress", "In Progress");
		ET::define("label.rejected", "Rejected");
		ET::define("label.highpriority", "High Priority");
		ET::define("label.lowpriority", "Low Priority");
	}
	public function handler_renderBefore($sender) 
    {
		$sender->addCSSFile($this->getResource("status.css"));
		$sender->addJSFile($this->getResource("status.js"));
	}
	public function handler_conversationController_renderScrubberBefore($sender, $data) 
    {
		if(!ET::$session->user) return;
		if($data["conversation"]["canModerate"]) 
        {
			$statuses = array(
				0 => "No Status",
				1 => "Done",
				2 => "In Progress",
				3 => "Rejected",
				4 => "High Priority",
				5 => "Low Priority"
			);
			$statuses_icons = array(
				0 => "remove",
				1 => "check",
				2 => "cogs",
				3 => "thumbs-down",
				4 => "circle",
				5 => "circle-blank"
			);
			$max = sizeof($statuses);
			$controls = "<ul id='conversationStatusControls' class='statuscontrols'>";
			for($i = 0; $i < $max; $i++) 
            {
				$controls = $controls . "
								<li><a href='". URL("conversation/status/". $data["conversation"]["conversationId"] .
											"?status=". $i .
											"&token=". ET::$session->token .
											"&return=". urlencode(ET::$controller->selfURL)) .
											"' title='". T($statuses[$i]) ."'>
									<i class='icon-". $statuses_icons[$i] ."'></i> 
									<span>". $statuses[$i] . "</span>
								</a></li>";
			}
			echo $controls . "</ul>";
		} else 
        {
			return;	
		}
	}
	public function conversationController_status($sender, $conversationId) 
    {
	
		$conversation = ET::conversationModel()->getById((int)$conversationId);
        
		if (!$sender->validateToken() || !$conversation) return;
		if(!$conversation["canModerate"]) 
        {
			$sender->renderMessage(T("Error"), T("message.noPermission"));
			return;
		}
        
		$model = ET::conversationModel();
		$model->updateById($conversationId, array("status" => $_GET["status"]));
		redirect(URL(R("return", conversationURL ($conversationId))));
	}
}
?>
