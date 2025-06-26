<?php echo view('adminpartial/header'); ?>
<div class="mt-6 grid grid-cols-2 gap-6 xl:grid-cols-1">

    <!-- update section -->
    <div class="card bg-teal-400 border-teal-400 shadow-md text-white">
        <div class="card-body flex flex-row">
            
            <!-- image -->
            <div class="img-wrapper w-40 h-40 flex justify-center items-center">
                <img src="./img/happy.svg" alt="img title">
            </div>
            <!-- end image -->

            <!-- info -->
            <div class="py-2 ml-10">
                <h1 class="h6">Good Job,
                    <?= isset($_SESSION['user']['name']) && $_SESSION['user']['name'] !== null ? htmlspecialchars($_SESSION['user']['name']) : 'Guest' ?>
                </h1>
                <p class="text-white text-xs">You've finished all of your tasks for this week.</p>

                <ul class="mt-4">
                    <li class="text-sm font-light"><i class="fad fa-check-double mr-2 mb-2"></i> Finish Dashboard Design</li>
                    <li class="text-sm font-light"><i class="fad fa-check-double mr-2 mb-2"></i> Fix Issue #74</li>
                    <li class="text-sm font-light"><i class="fad fa-check-double mr-2"></i> Publish version 1.0.6</li>
                </ul>
            </div>
            <!-- end info -->

        </div>
    </div>
    <!-- end update section -->

    <!-- carts -->
    <div class="flex flex-col">

        <!-- alert -->
        <div class="alert alert-dark mb-6">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Delectus corrupti ea dolorum blanditiis cum voluptates accusamus quisquam asperiores illo recusandae!
        </div>
        <!-- end alert -->

        <!-- charts -->
        <div class="grid grid-cols-2 gap-6 h-full">

            
        </div>     
        <!-- charts    -->

    </div>
    <!-- end charts -->


</div>

<?php 
echo view('adminpartial/footer'); ?>