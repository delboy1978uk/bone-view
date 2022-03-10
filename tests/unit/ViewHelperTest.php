<?php declare(strict_types=1);

namespace Bone\Test;

use Bone\View\Extension\Plates\AlertBox;
use Bone\View\Helper\Exception\PaginatorException;
use Bone\View\Helper\Paginator;
use Codeception\TestCase\Test;

class ViewHelperTest extends Test
{
    public function testPackage()
    {
        $viewHelperExtension = new AlertBox();
        $alert = $viewHelperExtension->alertBox(['Hello']);

        $this->assertEquals('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Hello</div>', $alert);
    }

    public function testWithCssClass()
    {
        $viewHelperExtension = new AlertBox();
        $alert = $viewHelperExtension->alertBox(['Hello', 'danger']);

        $this->assertEquals('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Hello</div>', $alert);
    }

    public function testMultiline()
    {
        $viewHelperExtension = new AlertBox();
        $alert = $viewHelperExtension->alertBox(['Hello', 'More text', 'danger']);

        $this->assertEquals('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Hello<br />More text</div>', $alert);
    }

    public function testPaginatorPageCountException()
    {
        $this->expectException(PaginatorException::class);
        $paginator = new Paginator();
        $paginator->render();
    }

    public function testPaginatorException()
    {
        $this->expectException(PaginatorException::class);
        $paginator = new Paginator();
        $paginator->setPageCount(3);
        $paginator->render();
    }

    public function testPaginator()
    {
        $viewHelper = new Paginator();
        $viewHelper->setCurrentPage(3);
        $viewHelper->setUrl('/some/page');
        $viewHelper->setPageCount(5);
        $viewHelper->setPagerSize(5);
        $pagination = $viewHelper->render();
        $this->assertEquals(5, $viewHelper->getPagerSize());
        $this->assertEquals('<nav><ul class="pagination"><li class="page-item"><a class="page-link"  href ="/some/page"><i class="fa fa-fast-backward"></i></a></li><li class="page-item"><a class="page-link"  href ="/some/page"><i class="fa fa-backward"></i></a></li><li class="page-item "><a class="page-link" href="/some/page">1</a></li><li class="page-item "><a class="page-link" href="/some/page">2</a></li><li class="page-item  active" aria-current="page"><a class="page-link" href="#">3</a></li><li class="page-item "><a class="page-link" href="/some/page">4</a></li><li class="page-item "><a class="page-link" href="/some/page">5</a></li><li class="page-item"><a class="page-link"  href ="/some/page"><i class="fa fa-forward"></i></i></a></li><li class="page-item"><a class="page-link"  href ="/some/page"><i class="fa fa-fast-forward"></i></i></a></li></ul></nav>', $pagination);
    }

    public function testCalculateStart()
    {
        $viewHelper = new Paginator();
        $viewHelper->setCurrentPage(2);
        $viewHelper->setUrl('/some/page');
        $viewHelper->setPageCount(5);
        $viewHelper->setPagerSize(5);
        $pagination = $viewHelper->render();
        $this->assertEquals(5, $viewHelper->getPagerSize());
        $this->assertEquals('<nav><ul class="pagination"><li class="page-item"><a class="page-link"  href ="/some/page"><i class="fa fa-fast-backward"></i></a></li><li class="page-item"><a class="page-link"  href ="/some/page"><i class="fa fa-backward"></i></a></li><li class="page-item "><a class="page-link" href="/some/page">1</a></li><li class="page-item  active" aria-current="page"><a class="page-link" href="#">2</a></li><li class="page-item "><a class="page-link" href="/some/page">3</a></li><li class="page-item "><a class="page-link" href="/some/page">4</a></li><li class="page-item "><a class="page-link" href="/some/page">5</a></li><li class="page-item"><a class="page-link"  href ="/some/page"><i class="fa fa-forward"></i></i></a></li><li class="page-item"><a class="page-link"  href ="/some/page"><i class="fa fa-fast-forward"></i></i></a></li></ul></nav>', $pagination);
    }

    public function testCalculateStart2()
    {
        $viewHelper = new Paginator();
        $viewHelper->setCurrentPage(3);
        $viewHelper->setUrl('/some/page/:number');
        $viewHelper->setUrlPart(':number');
        $viewHelper->setPageCount(10);
        $viewHelper->setPagerSize(7);
        $pagination = $viewHelper->render();
        $this->assertEquals('<nav><ul class="pagination"><li class="page-item"><a class="page-link"  href ="/some/page/1"><i class="fa fa-fast-backward"></i></a></li><li class="page-item"><a class="page-link"  href ="/some/page/2"><i class="fa fa-backward"></i></a></li><li class="page-item "><a class="page-link" href="/some/page/1">1</a></li><li class="page-item "><a class="page-link" href="/some/page/2">2</a></li><li class="page-item  active" aria-current="page"><a class="page-link" href="#">3</a></li><li class="page-item "><a class="page-link" href="/some/page/4">4</a></li><li class="page-item "><a class="page-link" href="/some/page/5">5</a></li><li class="page-item "><a class="page-link" href="/some/page/6">6</a></li><li class="page-item "><a class="page-link" href="/some/page/7">7</a></li><li class="page-item"><a class="page-link"  href ="/some/page/4"><i class="fa fa-forward"></i></i></a></li><li class="page-item"><a class="page-link"  href ="/some/page/10"><i class="fa fa-fast-forward"></i></i></a></li></ul></nav>', $pagination);
    }

    public function testSetPageCountByTotalRecords()
    {
        $viewHelper = new Paginator();
        $viewHelper->setCurrentPage(1);
        $viewHelper->setUrl('/some/page');
        $viewHelper->setPageCountByTotalRecords(30, 10);
        $pagination = $viewHelper->render();
        $this->assertEquals('<nav><ul class="pagination"><li class="page-item disabled"><a class="page-link"  href ="#"><i class="fa fa-fast-backward disabled"></i></a></li><li class="page-item disabled"><a class="page-link"  href ="#"><i class="fa fa-backward disabled"></i></a></li><li class="page-item  active" aria-current="page"><a class="page-link" href="#">1</a></li><li class="page-item "><a class="page-link" href="/some/page">2</a></li><li class="page-item "><a class="page-link" href="/some/page">3</a></li><li class="page-item"><a class="page-link"  href ="/some/page"><i class="fa fa-forward"></i></i></a></li><li class="page-item"><a class="page-link"  href ="/some/page"><i class="fa fa-fast-forward"></i></i></a></li></ul></nav>', $pagination);
    }

    public function testLastPage()
    {
        $viewHelper = new Paginator();
        $viewHelper->setCurrentPage(3);
        $viewHelper->setUrl('/some/page');
        $viewHelper->setPageCountByTotalRecords(30, 10);
        $pagination = $viewHelper->render();
        $this->assertEquals('<nav><ul class="pagination"><li class="page-item"><a class="page-link"  href ="/some/page"><i class="fa fa-fast-backward"></i></a></li><li class="page-item"><a class="page-link"  href ="/some/page"><i class="fa fa-backward"></i></a></li><li class="page-item "><a class="page-link" href="/some/page">1</a></li><li class="page-item "><a class="page-link" href="/some/page">2</a></li><li class="page-item  active" aria-current="page"><a class="page-link" href="#">3</a></li><li class="page-item disabled"><a class="page-link" href="#"><i class="fa fa-forward disabled"></i></a></li><li class="page-item disabled"><a class="page-link" href="#"><i class="fa fa-fast-forward disabled"></i></a></li></ul></nav>', $pagination);
    }

    public function testEvenPagerSizePage()
    {
        $viewHelper = new Paginator();
        $viewHelper->setCurrentPage(3);
        $viewHelper->setUrl('/some/page');
        $viewHelper->setPagerSize(4);
        $viewHelper->setPageCount(4);
        $pagination = $viewHelper->render();
        $this->assertEquals('<nav><ul class="pagination"><li class="page-item"><a class="page-link"  href ="/some/page"><i class="fa fa-fast-backward"></i></a></li><li class="page-item"><a class="page-link"  href ="/some/page"><i class="fa fa-backward"></i></a></li><li class="page-item "><a class="page-link" href="/some/page">2</a></li><li class="page-item  active" aria-current="page"><a class="page-link" href="#">3</a></li><li class="page-item "><a class="page-link" href="/some/page">4</a></li><li class="page-item"><a class="page-link"  href ="/some/page"><i class="fa fa-forward"></i></i></a></li><li class="page-item"><a class="page-link"  href ="/some/page"><i class="fa fa-fast-forward"></i></i></a></li></ul></nav>', $pagination);
    }

    public function testLotsOfPages()
    {
        $viewHelper = new Paginator();
        $viewHelper->setCurrentPage(20);
        $viewHelper->setUrl('/some/page/:number');
        $viewHelper->setUrlPart(':number');
        $viewHelper->setPageCountByTotalRecords(3000, 10);
        $pagination = $viewHelper->render();
        $this->assertEquals('<nav><ul class="pagination"><li class="page-item"><a class="page-link"  href ="/some/page/1"><i class="fa fa-fast-backward"></i></a></li><li class="page-item"><a class="page-link"  href ="/some/page/19"><i class="fa fa-backward"></i></a></li><li class="page-item "><a class="page-link" href="/some/page/18">18</a></li><li class="page-item "><a class="page-link" href="/some/page/19">19</a></li><li class="page-item  active" aria-current="page"><a class="page-link" href="#">20</a></li><li class="page-item "><a class="page-link" href="/some/page/21">21</a></li><li class="page-item "><a class="page-link" href="/some/page/22">22</a></li><li class="page-item"><a class="page-link"  href ="/some/page/21"><i class="fa fa-forward"></i></i></a></li><li class="page-item"><a class="page-link"  href ="/some/page/300"><i class="fa fa-fast-forward"></i></i></a></li></ul></nav>', $pagination);
    }
}
