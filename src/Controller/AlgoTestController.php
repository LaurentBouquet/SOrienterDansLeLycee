<?php

namespace App\Controller;

use App\Form\AlgoTestType;
use App\Repository\ConnectionRepository;
use App\Repository\LocationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class AlgoTestController extends AbstractController
{
    private ConnectionRepository $connectionRepository;
    private LocationRepository $locationRepository;

    public function __construct(ConnectionRepository $connectionRepository, LocationRepository $locationRepository)
    {
        $this->connectionRepository = $connectionRepository;
        $this->locationRepository = $locationRepository;
    }

    #[Route('/algo/new', name: 'app_algo_new', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $form = $this->createForm(AlgoTestType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $start = $data['start']->getName();
            $end = $data['end']->getName();

            $graph = $this->getGraph();
            $pathLocations = $this->dijkstra($graph, $start, $end);
            $path = $this->addInstructionsToPath($pathLocations);
            
            // Store path in session
            $request->getSession()->set('path', $path);
            
            return $this->redirectToRoute('app_algo_path', ['path' => $path], Response::HTTP_SEE_OTHER);
        }

        return $this->render('algo_test/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/algo/path', name: 'app_algo_path', methods: ['GET'])]
    public function path(Request $request): Response {
        $path = $request->getSession()->get('path', []);

        return $this->render('algo_test/path.html.twig', [
            'path' => $path,
        ]);
    }

    function dijkstra($graph_array, $source, $target) {
        $vertices = array();
        $neighbours = array();
        foreach ($graph_array as $edge) {
            array_push($vertices, $edge[0], $edge[1]);
            $neighbours[$edge[0]][] = array("end" => $edge[1], "cost" => $edge[2]);
            $neighbours[$edge[1]][] = array("end" => $edge[0], "cost" => $edge[2]);
        }
        $vertices = array_unique($vertices);

        foreach ($vertices as $vertex) {
            $dist[$vertex] = INF;
            $previous[$vertex] = NULL;
        }

        $dist[$source] = 0;
        $Q = $vertices;
        while (count($Q) > 0) {

            // TODO - Find faster way to get minimum
            $min = INF;
            foreach ($Q as $vertex){
                if ($dist[$vertex] < $min) {
                    $min = $dist[$vertex];
                    $u = $vertex;
                }
            }

            $Q = array_diff($Q, array($u));
            if ($dist[$u] == INF or $u == $target) {
                break;
            }

            if (isset($neighbours[$u])) {
                foreach ($neighbours[$u] as $arr) {
                    $alt = $dist[$u] + $arr["cost"];
                    if ($alt < $dist[$arr["end"]]) {
                        $dist[$arr["end"]] = $alt;
                        $previous[$arr["end"]] = $u;
                    }
                }
            }
        }
        $path = array();
        $u = $target;
        while (isset($previous[$u])) {
            array_unshift($path, $u);
            $u = $previous[$u];
        }
        array_unshift($path, $u);
        return $path;
    }

    function addInstructionsToPath($pathLocations) {
        $pathInstructions = [];
        
        for ($i = 0; $i < count($pathLocations) - 1; $i++) {
            $currentLocation = $pathLocations[$i];
            $nextLocation = $pathLocations[$i + 1];
            
            // Find the connection between current and next location
            $connections = $this->connectionRepository->findAll();
            $instruction = '';
            
            foreach ($connections as $connection) {
                $locAName = $connection->getLocationA()->getName();
                $locBName = $connection->getLocationB()->getName();
                
                if (($locAName === $currentLocation && $locBName === $nextLocation) || 
                    ($locAName === $nextLocation && $locBName === $currentLocation)) {
                    
                    if ($locAName === $currentLocation && $locBName === $nextLocation) {
                        $instruction = $connection->getInstructionAtoB();
                    } else {
                        $instruction = $connection->getInstructionBtoA();
                    }
                }
            }
            
            $pathInstructions[] = [
                'location' => $currentLocation,
                'instruction' => $instruction,
            ];
        }
         
        $pathInstructions[] = [
            'location' => end($pathLocations),
            'instruction' => null,
        ];
        
        return $pathInstructions;
    }

    function getGraph()
    {
        $connections = $this->connectionRepository->findAll();
        $graph_array = array();
        
        foreach ($connections as $connection) {
            $graph_array[] = array(
                $connection->getLocationA()->getName(),
                $connection->getLocationB()->getName(),
                $connection->getWeight(),
            );
        }
        
        return $graph_array;
    }
}
