<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Content/Blog Form</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-light p-4">
    <div class="container">
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <h2 class="mb-4">Add Multiple Coures and Modules</h2>

        @if($errors->any())
        <div class="alert alert-danger">
            <strong>Validation Failed:</strong> Please fix the errors below.
        </div>
        @endif

        <form action="{{ route('store') }}" method="POST">
            @csrf
            <button type="button" id="addContentBtn" class="btn btn-primary mb-4">Add Course</button>

            <div id="contentWrapper">
                @if(old('courses'))
                @foreach(old('courses') as $i => $content)
                <div class="content mb-4 p-4 bg-white shadow-sm rounded">
                    <h4>Content {{ $i + 1 }}</h4>
                    <div class="mb-2">
                        <input type="text" name="courses[{{ $i }}][courses_title]" class="form-control form-control-sm mb-1"
                            value="{{ $content['courses_title'] }}" placeholder="Content title">
                        @error("courses.$i.courses_title")
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="button" class="addBlogBtn btn btn-sm btn-secondary mb-3">Add More Modules</button>

                    <div class="modules">
                        @foreach($content['modules'] as $j => $blog)
                        <div class="blog mb-3">
                            <h6>Blog {{ $j + 1 }}</h6>
                            <input type="text" name="courses[{{ $i }}][modules][{{ $j }}][title]" class="form-control form-control-sm mb-1"
                                value="{{ $blog['title'] }}" placeholder="Blog title">
                            @error("courses.$i.modules.$j.title")
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror

                            <input type="text" name="courses[{{ $i }}][modules][{{ $j }}][body]" class="form-control form-control-sm"
                                value="{{ $blog['body'] }}" placeholder="Blog body">
                            @error("courses.$i.modules.$j.body")
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
                @else
                <div class="content mb-4 p-4 bg-white shadow-sm rounded">
                    <h4>Course 1</h4>
                    <div class="mb-2">
                        <input type="text" name="courses[0][courses_title]" class="form-control form-control-sm mb-1" placeholder="Course title">
                    </div>

                    <button type="button" class="addBlogBtn btn btn-sm btn-secondary mb-3">Add More Modules</button>

                    <div class="modules">
                        <div class="blog mb-3">
                            <h6>Module 1</h6>
                            <input type="text" name="courses[0][modules][0][title]" class="form-control form-control-sm mb-1" placeholder="Module title">
                            <input type="text" name="courses[0][modules][0][body]" class="form-control form-control-sm" placeholder="Module body">
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {

            let contentIndex = {
                {
                    old('courses') ? count(old('courses')) : 1
                }
            };

            // Add Content
            $('#addContentBtn').click(function() {
                const contentTemplate = $('.content:first').clone();
                contentTemplate.find('h4').text('Content ' + (contentIndex + 1));

                // Update content title input
                contentTemplate.find('input[name$="[courses_title]"]').val('');
                contentTemplate.find('input[name$="[courses_title]"]').attr('name', `courses[${contentIndex}][courses_title]`);

                // Reset and update first blog
                const firstBlog = contentTemplate.find('.blog:first').clone();
                firstBlog.find('h6').text('Blog 1');
                firstBlog.find('input').each(function(index) {
                    $(this).val('');
                    const type = index === 0 ? 'title' : 'body';
                    $(this).attr('name', `courses[${contentIndex}][modules][0][${type}]`);
                });

                // Remove all modules, append one clean
                contentTemplate.find('.modules').html(firstBlog);

                $('#contentWrapper').append(contentTemplate);
                contentIndex++;
            });

            // Add Blog
            // Add Blog
            $(document).on('click', '.addBlogBtn', function() {
                const contentDiv = $(this).closest('.content');
                const modulesWrapper = contentDiv.find('.modules');
                const blogCount = modulesWrapper.find('.blog').length;
                const contentIdx = $('#contentWrapper .content').index(contentDiv);

                const blogTemplate = modulesWrapper.find('.blog:first').clone();
                blogTemplate.find('h6').text('Module ' + (blogCount + 1));

                blogTemplate.find('input').each(function() {
                    $(this).val('');
                    const typeMatch = $(this).attr('name').match(/\[(title|body)\]$/);
                    const type = typeMatch ? typeMatch[1] : '';
                    $(this).attr('name', `courses[${contentIdx}][modules][${blogCount}][${type}]`);
                });

                modulesWrapper.append(blogTemplate);
            });

        });
    </script>
</body>

</html>