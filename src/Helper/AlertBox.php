<?php

namespace Bone\View\Helper;

class AlertBox
{
    /**
     * @param array $message array of messages, last item in array should be alert class
     * @return string
     */
    public function alertBox(array $message, bool $closeButton = true): string
    {
        $class = $this->getClass($message);
        $alert = '<div class="alert ' . $class . '">';
        $alert .= $closeButton ? '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' : '';
        $alert .= $this->renderMessage($message) . '</div>';

        return $alert;
    }

    private function getClass(array $message): string
    {
        if (count($message) < 2) {
            return 'alert-info';
        }

        $class = array_pop($message);
        $class = (strpos($class, 'alert-') === false) ? 'alert-' . $class : '';

        return $class;
    }

    private function renderMessage(array $message): string
    {
        $alert = '';

        if (count($message) > 1) {
            array_pop($message);
        }

        $num = count($message);
        $x = 1;

        foreach ($message as $msg) {
            $alert .= $msg;
            if ($x < $num) {
                $alert .= '<br />';
            }
            $x++;
        }

        return $alert;
    }
}
