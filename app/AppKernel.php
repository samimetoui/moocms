<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
  public function getRootDir()
  {
    return __DIR__;
  }
  
  public function getCacheDir()
  {
    return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
  }

  public function getLogDir()
  {
    return dirname(__DIR__).'/var/logs';
  }

  public function registerBundles()
  {
    $bundles = array(
      new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
      new Symfony\Bundle\SecurityBundle\SecurityBundle(),
      new Symfony\Bundle\TwigBundle\TwigBundle(),
      new Symfony\Bundle\MonologBundle\MonologBundle(),
      new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
      new Symfony\Bundle\AsseticBundle\AsseticBundle(),
      new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
      new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

      //new AppBundle\AppBundle(),
      new sf_moocms\MoocmsBundle\MoocmsBundle(),
      new Application\Sonata\MediaBundle\ApplicationSonataMediaBundle(),

      new FOS\UserBundle\FOSUserBundle(),

      // These are the other bundles the SonataAdminBundle relies on
      new Sonata\CoreBundle\SonataCoreBundle(),
      new Sonata\BlockBundle\SonataBlockBundle(),
      new Knp\Bundle\MenuBundle\KnpMenuBundle(),

      // And finally
      new Sonata\AdminBundle\SonataAdminBundle(),

      new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),

      new Sonata\MediaBundle\SonataMediaBundle(),
      new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),

      // new JMS\SerializerBundle\JMSSerializerBundle(),

      new CoopTilleuls\Bundle\CKEditorSonataMediaBundle\CoopTilleulsCKEditorSonataMediaBundle(),
      new FOS\CKEditorBundle\FOSCKEditorBundle(),

      // new Ivory\CKEditorBundle\IvoryCKEditorBundle(),

      new sf_moocms\UserBundle\UserBundle(),

      new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),

      new \Symfony\WebpackEncoreBundle\WebpackEncoreBundle(),
    );

    if (in_array($this->getEnvironment(), array('dev', 'test'), true)) {
      $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
      $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
      $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
      $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
      // $bundles[] = new CoreSphere\ConsoleBundle\CoreSphereConsoleBundle();
      $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
    }

    return $bundles;
  }

  public function registerContainerConfiguration(LoaderInterface $loader)
  {
    $loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
  }
}
