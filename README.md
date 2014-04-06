## esoTalk – Conversation Status plugin

Allows those who can moderate to set a status to conversations.

This is a shabby, bloated (than what it could have been) plugin - but it gets the job done! 


### Installation

Browse to your esoTalk plugin directory:
```
cd WEB_ROOT_DIR/addons/plugins/
```

Clone the Conversation Status plugin repo into the plugin directory:
```
git clone git@github.com:esoTalk-plugins/ConversationStatus.git ConversationStatus
```

Chown the Conversation Status plugin folder to the right web user:
```
chown -R apache:apache ConversationStatus/
```

If you are updating this plugin from 0.5 prior, to 0.6; the statuses have changed. What status has been assigned to conversations previously will not be the same as what is displayed after updating. This may require re-statusing a lot of conversations. 
An upgrade script will be worked on for when the develop branch is pulled to the master.
