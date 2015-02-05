---
title: Exploring HHVM Internals
---

Starting work on an existing open source project can be pretty overwhelming, especially if you don't know where everything is kept. This blog post is basically a catalogue of my findings from exploring the HHVM internals, primarily for my personal future reference, and also just in case anyone else might find it useful. I'm not going to list every single file and folder - otherwise this post will be enormous, so I'm just going to focus on the main parts. Let's start off at the top, and visit [github.com/facebook/hhvm](https://github.com/facebook/hhvm)... at the root level, there are various build / configure / third party modules, but the folder that we'll mostly need is the hphp folder, so we'll descend straight into there.

* `hphp/parser` The lexer and parser live here. The lexer definition lives in hphp/parser/hphp.ll (uses Flex to turn PHP into tokens). The parser takes these tokens and magics them into an Abstract Syntax Tree.
* `hphp/compiler` This is the "front end" compiler - it takes the Abstract Syntax Tree and creates bytecode (and optimises it a little). You can generate the actual bytecode for a PHP file simply by running `hhvm -vEval.DumpBytecode=1 file.php`. Basically, this runs the lexer, parser and front end compilation steps.
* `hphp/hhbbc` Bytecode-to-Bytecode Compiler. As the name suggests, this takes bytecode, optimises it (some more), and generates bytecode.
* `hphp/hack` This is where the hack language stuff is - mostly OCaml
* `hphp/hhvm` Just a few source files here - the entry point for the `hhvm` binary (Hint: `int main(..)` is here!)
* `hphp/runtime/vm` This is the HHVM interpreter - the virtual machine that executes the bytecode, primarily in [bytecode.cpp](https://github.com/facebook/hhvm/blob/master/hphp/runtime/vm/bytecode.cpp), you'll find the iop* functions, for example iopPrint.
* `hphp/runtime/vm/jit` The JIT compiler - this takes "hot" bytecode, and compiles to native code. There are a few steps here:
  * Intermediate Representation (IR)
  * Virtual assembly (Vasm instructions) - this is basically assembly code, but without CPU-specific instructions
  * Machine code - the CPU-specific assembly
* `hphp/system/php` Various pure PHP implementations such as Redis, password, SPL, stdClass (written in PHP!) which get put in `systemlib.php` (think of this as a block of PHP that is `auto_prepend_file` every request, but persists so there is no overhead). These are pretty sweet as you don't need to know *any* C++ to work on these.
* `hphp/runtime/ext` PHP and C++ Extensions. You can find out how to write these sort of extensions from Sara Golemon's series on [HHVM extensions](http://blog.golemon.com/2015/01/hhvm-extension-writing-part-i.html). This (and `hphp/system/php`) is actually where most of the implementation of stuff happens. Everything else is pretty much just the "language" implementation (i.e. lexing, parsing, bytecode compilation, interpreting, JIT compilation). You can write extensions primarily using PHP here, but dip into native C++ using HHVM-Native Interface (HNI). More docs in the [Extension-API](https://github.com/facebook/hhvm/wiki/Extension-API), and check out Derick Rethans' cookbook on [writing extensions](https://github.com/derickr/hhvm-hni-cookbook).

Resources:

* http://blog.golemon.com/2015/01/hhvm-extension-writing-part-i.html
* http://hhvm.com/blog/6323/the-journey-of-a-thousand-bytecodes
* https://github.com/facebook/hhvm/blob/master/hphp/hhbbc/README
* https://github.com/facebook/hhvm/tree/master/hphp
* https://github.com/facebook/hhvm/wiki/Extension-API
* http://www.slideshare.net/auroraeosrose/hacking-with-hhvm/13
* https://github.com/derickr/hhvm-hni-cookbook
