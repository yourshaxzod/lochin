<?php

namespace Shaxzod\Lochin\Telegram\Properties;

enum ChatType: string
{
    case SENDER = 'sender';
    case PRIVATE = 'private';
    case GROUP = 'group';
    case SUPERGROUP = 'supergroup';
    case CHANNEL = 'channel';
}