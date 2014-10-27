<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 * @package         Registry
 */

namespace Module\Article\Registry;

use Pi;
use Pi\Application\Registry\AbstractRegistry;

/**
 * Pi article compound field registry
 *
 * @author Zongshu Lin <lin40553024@163.com>
 */
class CompoundField extends AbstractRegistry
{
    /** @var string Module name */
    protected $module = 'article';

    /**
     * {@inheritDoc}
     */
    protected function loadDynamic($options = array())
    {
        $fields = array();

        $columns = array('id', 'name', 'title', 'compound', 'edit', 'filter', 'is_required');
        $where = array('compound' => $options['compound']);
        $model = Pi::model('compound_field', $this->module);
        $select = $model->select()->where($where)
            ->columns($columns)
            ->order('id');
        $rowset = $model->selectWith($select);
        foreach ($rowset as $row) {
            $fields[$row->name] = $row->toArray();
        }

        return $fields;
    }

    /**
     * {@inheritDoc}
     * @param string $compound Compound name: tool, address, education, work
     * @param array
     */
    public function read($compound = '')
    {
        $options = array('compound' => $compound);
        $data = $this->loadData($options);

        return $data;
    }

    /**
     * {@inheritDoc}
     * @param string $compound
     */
    public function create($compound = '')
    {
        $this->clear('');
        $this->read($compound);

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function setNamespace($meta = '')
    {
        return parent::setNamespace('');
    }

    /**
     * {@inheritDoc}
     */
    public function flush()
    {
        return $this->clear('');
    }
}