## esoTalk – Conversation Status plugin

- Allow those who can moderate to set a status to conversations.

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

Note that this plugin will not work on esoTalk 1.0.0g4 and above
