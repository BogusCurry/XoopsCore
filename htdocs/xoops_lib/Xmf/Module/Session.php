<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace Xmf\Module;

use Xmf\Module\Helper\AbstractHelper;

/**
 * Manage session variables for a module. Session variable will be
 * prefixed with the module name to separate it from variables set
 * by other modules or system functions. All data is serialized, so
 * any arbitrary data (i.e. array) can be stored.
 *
 * @category  Xmf\Module\Helper\Session
 * @package   Xmf
 * @author    trabis <lusopoemas@gmail.com>
 * @author    Richard Griffith <richard@geekwright.com>
 * @copyright 2011-2013 The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license   GNU GPL 2 or later (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @version   Release: 1.0
 * @link      http://xoops.org
 * @since     1.0
 */
class Session extends AbstractHelper
{
    /**
     * @var string
     */
    private $prefix;

    /**
     * Initialize parent::__constuct calls this after verifying module object.
     *
     * @return void
     */
    public function init()
    {
        $this->prefix = $this->module->getVar('dirname') . '_';
    }

    /**
     * Add our module prefix to a name
     *
     * @param string $name name to prefix
     *
     * @return string module prefixed name
     */
    private function prefix($name)
    {
        $prefixedName = $this->prefix . $name;

        return $prefixedName;
    }

    /**
     * Sets a named session variable respecting our module prefix
     *
     * @param string $name  name of variable
     * @param mixed  $value value of variable
     *
     * @return void
     */
    public function set($name, $value)
    {
        $prefixedName = $this->prefix($name);
        $_SESSION[$prefixedName] = serialize($value);
    }

    /**
     * Fetch a named session variable respecting our module prefix
     *
     * @param string $name name of variable
     *
     * @return mixed  $value value of session variable or false if not set
     */
    public function get($name)
    {
        $prefixedName = $this->prefix($name);
        if (isset($_SESSION[$prefixedName])) {
            return unserialize($_SESSION[$prefixedName]);
        } else {
            return false;
        }
    }

    /**
     * Deletes a named session variable respecting our module prefix
     *
     * @param string $name name of variable
     *
     * @return void
     */
    public function del($name)
    {
        $prefixedName = $this->prefix($name);
        $_SESSION[$prefixedName] = null;
        unset($_SESSION[$prefixedName]);
    }

    /**
     * Delete all session variable starting with our module prefix
     *
     * @return void
     */
    public function destroy()
    {
        foreach ($_SESSION as $key => $value) {
            if (0 == substr_compare($key, $this->prefix, 0, strlen($this->prefix))) {
                $_SESSION[$key] = null;
                unset($_SESSION[$key]);
            }
        }
    }
}
