<?php

function pretty_var_dump($variable, $variable_name = 'variable', $indentation = 0, $outermost = true)
{
  $type = gettype($variable);
  if ($outermost) {
    echo "<code ondblclick='
            var messageElement = document.createElement(\"div\");
            messageElement.innerText = \"Copying code to clipboard...\";
            messageElement.style.cssText = \"position: fixed; top: 50%; left: 50%; transform: translateX(-50%); padding: 10px; background-color: rgba(0, 0, 0, 0.8); color: white; border-radius: 5px;\";
            document.body.appendChild(messageElement);

            navigator.clipboard.writeText(this.innerText).then(function() {
                setTimeout(function() {
                    messageElement.innerText = \"\";
                    document.body.removeChild(messageElement);
                }, 1000);
            });
        ' style='cursor: pointer; margin: 2rem'>";
    echo "<pre style='font-family: Fira Code; font-size: .9rem; line-height: 1.45; background: hsl(0deg 0% 92%); padding: 2rem; max-width: 1000px; margin-inline: auto;'>";
    echo "<span style='font-weight: 500; color: hsl(240deg 80% 55%)'>\$$variable_name</span> = ";
  }
  if ($type === 'integer' || $type === 'string' || $type === 'boolean') {
    echo "<span style='font-weight: 300;'>$variable</span> (<span style='font-weight: 300;'>$type</span>)";
  } elseif ($type === 'array') {
    echo "{\n";
    $count = count($variable);
    $i = 0;
    foreach ($variable as $key => $value) {
      echo str_repeat(' ', ($indentation + 1) * 3) . "<span style='font-weight: 500;'>$key</span>: ";
      if (is_array($value)) {
        pretty_var_dump($value, '', $indentation + 1, false);
      } else {
        echo is_numeric($value) ? $value : "'$value'";
      }
      if (++$i !== $count) {
        echo ",\n";
      } else {
        echo "\n";
      }
    }
    echo str_repeat(' ', $indentation * 3) . "}";
  }
  if ($outermost) {
    echo "</pre>";
    echo "</code>";
  }
}
