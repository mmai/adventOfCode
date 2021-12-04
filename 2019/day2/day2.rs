use std::fs;

struct Program {
    state: Vec<usize>,
    pos: usize
}

impl Program {
    pub fn overflow(&self) -> bool {
        &self.pos > &self.state.len()
    }

    pub fn get_val(&self, pos: usize) -> usize {
        self.state[pos]
    }

    pub fn set_val(self: &mut Program , pos: usize, val: usize){
        self.state[pos] = val;
    }

    pub fn goto_next(self: &mut Program ){
        self.pos = self.pos + 4;
    }

    pub fn run_step (self: &mut Program ) -> bool {
        if self.overflow() {
            true
        } else {
            let opcode = self.get_val(self.pos);
            match opcode {
                1 => {
                    let arg1 = self.get_val(self.get_val(self.pos + 1));
                    let arg2 = self.get_val(self.get_val(self.pos + 2));
                    let dest = self.get_val(self.pos + 3);
                    self.set_val(dest, arg1 + arg2);
                    self.goto_next();
                    false
                },
                2 => {
                    let arg1 = self.get_val(self.get_val(self.pos + 1));
                    let arg2 = self.get_val(self.get_val(self.pos + 2));
                    let dest = self.get_val(self.pos + 3);
                    self.set_val(dest, arg1 * arg2);
                    self.goto_next();
                    false
                },
                99 => true,
                _ => true,
            }
        }
    }

    pub fn run (self: &mut Program ) {
        let mut finished: bool = false;
        while !finished {
            finished = self.run_step();
        }
    }

}

fn runPair(state: &Vec<usize>, noun: usize, verb: usize) -> usize {
    let mut prog = Program {
        state: state.clone(),
        pos: 0
    };
    prog.set_val(1, noun); 
    prog.set_val(2, verb);
    prog.run();
    prog.get_val(0)
}

fn main() {
    let contents = fs::read_to_string("day2input.txt")
        .expect("Something went wrong reading the file");

    let state: Vec<usize> = contents.trim().split(",").map(|s| s.parse().unwrap()).collect();
    // let contents = "1,1,1,4,99,5,6,0,99";

    let mut noun = 0;
    let mut verb = 0;

    let mut res = 0;
    for noun in (0..99) {
        for verb in (0..99) {
            res = runPair(&state, noun, verb);
            if (res == 19690720){
                println!("noun: {}, verb: {}", noun, verb);
            }
        }
    }

    // let res = runPair(&state, 2, 2);
    //
    // println!("{}", res); // 
}
