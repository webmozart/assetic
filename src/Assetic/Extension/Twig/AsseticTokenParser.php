<?php

/*
 * This file is part of the Assetic package, an OpenSky project.
 *
 * (c) 2010-2014 OpenSky Project Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Assetic\Extension\Twig;

use Assetic\Asset\AssetInterface;
use Assetic\Factory\AssetFactory;

class AsseticTokenParser extends BaseAsseticTokenParser
{
    private $factory;

    /**
     * Constructor.
     *
     * Attributes can be added to the tag by passing names as the options
     * array. These values, if found, will be passed to the factory and node.
     *
     * @param AssetFactory $factory    The asset factory
     * @param string       $tag        The tag name
     * @param string       $output     The default output string
     * @param Boolean      $single     Whether to force a single asset
     * @param array        $extensions Additional attribute names to look for
     */
    public function __construct(AssetFactory $factory, $tag, $output, $single = false, array $extensions = array())
    {
        parent::__construct($tag, $output, $single, $extensions);

        $this->factory    = $factory;
    }

    protected function createAsseticNode(\Twig_NodeInterface $body, array $inputs, array $filters, $name, array $attributes, $lineno, $tag)
    {
        if (!$name) {
            $name = $this->factory->generateAssetName($inputs, $filters, $attributes);
        }

        $asset = $this->factory->createAsset($inputs, $filters, $attributes + array('name' => $name));

        return $this->createNode($asset, $body, $inputs, $filters, $name, $attributes, $lineno, $tag);
    }

    protected function createNode(AssetInterface $asset, \Twig_NodeInterface $body, array $inputs, array $filters, $name, array $attributes = array(), $lineno = 0, $tag = null)
    {
        return new AsseticNode($asset, $body, $inputs, $filters, $name, $attributes, $lineno, $tag);
    }
}
